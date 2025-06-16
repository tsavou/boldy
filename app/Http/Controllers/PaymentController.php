<?php

namespace App\Http\Controllers;

use App\Models\Boost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function show(Request $request)
    {
        $mode = $request->query('mode');
        $option = $request->query('option');

        if (! in_array($mode, ['boost', 'premium'])) {
            abort(404);
        }

        return Inertia::render('Payment', [
            'mode' => $mode,
            'option' => $option,
        ]);
    }

    public function subscribePremium(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'plan' => 'required|in:premium_monthly,premium_yearly',
            'payment_method' => 'required|string', // id Stripe du moyen de paiement
        ]);

        $planId = config('stripe.plans.'.$request->plan);

        if (! $planId) {
            return response()->json(['message' => 'Plan invalide'], 422);
        }

        // Attacher le moyen de paiement au user
        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($request->payment_method);

        // Créer l'abonnement
        $subscription = $user->newSubscription('default', $planId)->create($request->payment_method);

        return response()->json(['message' => 'Abonnement créé avec succès', 'subscription' => $subscription]);
    }

    public function purchaseBoost(Request $request)
    {

        $user = auth()->user();
        $freelance = $user->freelance;

        $request->validate([
            'boost_duration' => 'required|in:7_days,14_days,30_days',
            'payment_method' => 'required|string',
        ]);
        $boostConfig = config('stripe.boosts.'.$request->boost_duration);

        if (! $boostConfig) {
            return response()->json(['message' => 'Durée boost invalide'], 422);
        }

        $amount = $boostConfig['amount'];
        // $priceId = $boostConfig['price_id'];

        if ($freelance->boosts()->where('end_date', '>', now())->exists()) {
            return response()->json(['message' => 'Vous avez déjà un boost actif'], 422);
        }

        $user->createOrGetStripeCustomer();

        // Créer la charge one-time
        \Stripe\Stripe::setApiKey(config('cashier.secret'));

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'eur',
            'payment_method' => $request->payment_method,
            'customer' => $user->stripe_id,
            'confirm' => true,
            'payment_method_types' => ['card'], // ← ici tu forces explicitement
            'description' => 'Achat boost '.$request->boost_duration,
        ]);

        // Définir les dates du boost
        $startDate = Carbon::now();

        $endDate = match ($request->boost_duration) {
            '7_days' => $startDate->copy()->addDays(7),
            '14_days' => $startDate->copy()->addDays(14),
            '30_days' => $startDate->copy()->addDays(30),
        };

        // Enregistrement en base
        Boost::create([
            'freelance_id' => $freelance->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return response()->json([
            'message' => 'Boost acheté et activé avec succès !',
            'paymentIntent' => $paymentIntent,
        ]);
    }
}

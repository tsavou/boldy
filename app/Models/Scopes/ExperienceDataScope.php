<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

class ExperienceDataScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Sous-requête pour calculer l'expérience en années
        $cte = DB::table('experiences')
            ->selectRaw('freelance_id, FLOOR(IFNULL(SUM(TIMESTAMPDIFF(MONTH, start_date, COALESCE(end_date, NOW()))), 0) / 12) as years') // somme des mois d'expérience et conversion en années
            ->groupBy('freelance_id'); // sélectionne pour chaque freelance l'expérience en années

        // Left join de la sous-requête et mapping des attributs
        $builder->leftJoinSub($cte, 'experience_data', 'freelances.id', '=', 'experience_data.freelance_id') // jointure avec la sous-requête → chaque freelance récupère son expérience en années
            ->addSelect('freelances.*')
            ->addSelect(DB::raw('IFNULL(experience_data.years, 0) as experience_in_years')) // ajout de l'attribut experience_in_years
                // recupération du niveau d'expérience en fonction de l'expérience en années et ajout de l'attribut experience_level
            ->selectRaw('
                CASE
                    WHEN IFNULL(experience_data.years, 0) < 1 THEN "Junior"
                    WHEN IFNULL(experience_data.years, 0) < 3 THEN "Intermédiaire"
                    WHEN IFNULL(experience_data.years, 0) < 5 THEN "Confirmé"
                    ELSE "Expert"
                END AS experience_level
            ');
    }
}

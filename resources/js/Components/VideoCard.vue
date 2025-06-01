<script setup>
import { ref } from 'vue';
import { PlayIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    src: String,
});

const isPlaying = ref(false);
const videoRef = ref(null);

const playVideo = () => {
    isPlaying.value = true;
    videoRef.value.play();
    videoRef.value.controls = true;
};
</script>

<template>
    <div class="group relative overflow-hidden rounded-xl shadow-lg">
        <video
            ref="videoRef"
            :src="src"
            class="aspect-video w-full object-cover transition duration-300"
            preload="metadata"
            playsinline
            @ended="isPlaying = false"
        ></video>

        <!-- Overlay quand vidéo non jouée -->
        <div
            v-if="!isPlaying"
            class="absolute inset-0 flex items-center justify-center bg-black/50 transition duration-300"
        >
            <button
                @click="playVideo"
                class="rounded-full bg-green-800/80 p-4 text-orange-50 transition duration-300 hover:bg-green-800 hover:text-orange-300"
            >
                <PlayIcon class="h-12 w-12" />
            </button>
        </div>
    </div>
</template>

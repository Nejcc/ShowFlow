<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $presentation->title }}</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎯</text></svg>">
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    animation: {
                        'fade-up': 'fade-up 0.5s ease-out forwards',
                        'fade-down': 'fade-down 0.5s ease-out forwards',
                        'bounce': 'bounce 1s infinite',
                    },
                    keyframes: {
                        'fade-up': {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        'fade-down': {
                            '0%': { opacity: '0', transform: 'translateY(-10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        'bounce': {
                            '0%, 100%': { transform: 'translateY(-5%)', animationTimingFunction: 'cubic-bezier(0.8, 0, 1, 1)' },
                            '50%': { transform: 'translateY(0)', animationTimingFunction: 'cubic-bezier(0, 0, 0.2, 1)' },
                        },
                    },
                },
            },
        }
    </script>
    <style>
        /* Your custom styles */
        {!! $css['app'] !!}
        {!! $css['animations'] !!}
    </style>
</head>
<body class="bg-gray-900 text-white">
    <div id="app"></div>

    <script type="module">
        const { createApp, ref, computed, onMounted, onUnmounted } = Vue;

        // Register layouts
        const layouts = {
            @foreach($layouts as $name => $content)
                '{{ $name }}': {!! json_encode($content) !!},
            @endforeach
        };

        // Register slide components
        const slides = {
            @foreach($slideComponents as $page => $content)
                '{{ $page }}': {!! json_encode($content) !!},
            @endforeach
        };

        // Create presentation data
        const presentationData = {!! json_encode($presentation) !!};

        // Create and mount the app
        const app = createApp({
            template: @json('
                <div class="presentation-container h-screen w-screen overflow-hidden" ref="presentationContainer" @keydown="handleKeyDown">
                    <div v-if="isLoading" class="fixed inset-0 flex items-center justify-center bg-black/50">
                        <div class="text-white text-2xl">Loading presentation...</div>
                    </div>

                    <button 
                        @click="toggleFullscreen"
                        class="fixed top-4 right-4 p-2 bg-white/10 rounded-lg backdrop-blur-sm hover:bg-white/20 transition-colors"
                        :title="isFullscreen ? \'Exit Fullscreen\' : \'Enter Fullscreen\'"
                    >
                        <svg v-if="!isFullscreen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-5h-4m0 0v4m0-4l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5h-4m0 0v-4m0 4l-5-5" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <transition
                        :name="slideTransition"
                        mode="out-in"
                    >
                        <div 
                            :key="currentSlide"
                            class="slide-container h-full w-full flex items-center justify-center p-8"
                            :class="[currentSlideData.background, currentSlideData.text_color]"
                        >
                            <component
                                v-if="currentSlideData.type === \'component\' && currentComponent"
                                :is="currentComponent"
                                v-bind="currentSlideData.props || {}"
                            />
                            <div v-else-if="currentSlideData.type === \'html\'" class="prose prose-invert max-w-none" v-html="currentSlideData.content"></div>
                            <div v-else-if="currentSlideData.type === \'text\'" class="prose prose-invert max-w-none">
                                <div v-for="(line, index) in currentSlideData.content.split(\'\n\')" 
                                     :key="index"
                                     class="animate-fade-up"
                                     :style="{ animationDelay: index * 0.1 + \'s\' }"
                                >
                                    @{{ line }}
                                </div>
                            </div>
                        </div>
                    </transition>

                    <div class="fixed bottom-4 right-4 bg-black/50 px-4 py-2 rounded-lg backdrop-blur-sm">
                        @{{ currentSlide + 1 }}/@{{ slides.length }}
                    </div>
                </div>
            '),
            setup() {
                const isLoading = ref(false);
                const currentSlide = ref(0);
                const slides = ref(presentationData.slides);
                const presentationContainer = ref(null);
                const isFullscreen = ref(false);
                const lastDirection = ref('right');

                const slideTransition = computed(() => {
                    return lastDirection.value === 'right' ? 'slide-fade-right' : 'slide-fade-left';
                });

                const currentSlideData = computed(() => slides.value[currentSlide.value] || {});

                const currentComponent = computed(() => {
                    if (!currentSlideData.value || currentSlideData.value.type !== 'component') {
                        return null;
                    }
                    return slides[currentSlideData.value.page] || null;
                });

                const toggleFullscreen = async () => {
                    if (!document.fullscreenElement) {
                        try {
                            await presentationContainer.value.requestFullscreen();
                            isFullscreen.value = true;
                        } catch (err) {
                            console.error('Error attempting to enable fullscreen:', err);
                        }
                    } else {
                        try {
                            await document.exitFullscreen();
                            isFullscreen.value = false;
                        } catch (err) {
                            console.error('Error attempting to exit fullscreen:', err);
                        }
                    }
                };

                const handleKeyDown = (event) => {
                    switch(event.key) {
                        case 'ArrowLeft':
                            if (currentSlide.value > 0) {
                                lastDirection.value = 'left';
                                currentSlide.value--;
                            }
                            break;
                        case 'ArrowRight':
                            if (currentSlide.value < slides.value.length - 1) {
                                lastDirection.value = 'right';
                                currentSlide.value++;
                            }
                            break;
                        case 'f':
                            toggleFullscreen();
                            break;
                    }
                };

                onMounted(() => {
                    window.addEventListener('keydown', handleKeyDown);
                    document.addEventListener('fullscreenchange', () => {
                        isFullscreen.value = !!document.fullscreenElement;
                    });
                });

                onUnmounted(() => {
                    window.removeEventListener('keydown', handleKeyDown);
                    document.removeEventListener('fullscreenchange', () => {
                        isFullscreen.value = !!document.fullscreenElement;
                    });
                });

                return {
                    isLoading,
                    currentSlide,
                    slides,
                    presentationContainer,
                    isFullscreen,
                    slideTransition,
                    currentSlideData,
                    currentComponent,
                    toggleFullscreen,
                    handleKeyDown
                };
            }
        });

        // Register all layouts as global components first
        Object.entries(layouts).forEach(([name, component]) => {
            app.component(name, {
                template: component,
                props: ['title', 'background', 'textColor'],
            });
        });

        // Register all slide components
        Object.entries(slides).forEach(([name, component]) => {
            app.component(name, {
                template: component,
            });
        });

        // Mount the app
        app.mount('#app');
    </script>
</body>
</html> 
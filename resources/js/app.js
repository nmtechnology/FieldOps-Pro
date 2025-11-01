import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import LoadingScreen from './Components/LoadingScreen.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Create loading screen container
const loadingContainer = document.createElement('div');
loadingContainer.id = 'loading-screen-container';
document.body.appendChild(loadingContainer);

const loadingApp = createApp({
    data() {
        return {
            show: true
        };
    },
    render() {
        return h(LoadingScreen, { show: this.show });
    }
});

const loadingInstance = loadingApp.mount(loadingContainer);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        // Hide loading screen when app is ready
        setTimeout(() => {
            loadingInstance.show = false;
            setTimeout(() => {
                loadingContainer.remove();
            }, 500);
        }, 2000);
        
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#f97316',
        showSpinner: false,
    },
});

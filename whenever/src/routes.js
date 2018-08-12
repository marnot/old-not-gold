import Home from './components/Home.vue';
import AddEvent from './components/Events/AddEvent.vue';
import Panel from './components/Users/userPanel.vue';
import Events from './components/Events/Events.vue';
import Event from './components/Events/Event.vue';
import EditEvent from './components/Events/EditEvent.vue';

export const routes = [
    // { path: '/', component: Events },
    { path: '/addEvent', component: AddEvent },
    { path: '/myPanel', component: Panel },
    { path: '/events', component: Events },
    { path: '/event', name: 'event', component: Event },
    { path: '/edit', name: 'edit', component: EditEvent }

];
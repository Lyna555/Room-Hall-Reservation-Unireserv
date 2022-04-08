require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

Vue.prototype.EventBus = new Vue();

Vue.component('users-component', require('./components/UsersComponent.vue').default);
Vue.component('message-component', require('./components/MessagesComponent.vue').default);
Vue.component('active-chats-component', require('./components/ActiveChatsComponent.vue').default);
Vue.component('stream-chat', require('./components/StreamChat.vue').default);
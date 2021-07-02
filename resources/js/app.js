/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import store from './store/index';

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
import 'swiper/swiper.scss'
var VueAwesomeSwiper = require('vue-awesome-swiper')
Vue.use(VueAwesomeSwiper)

// ユーザー画面
Vue.component('yet-project-sp-component', require('./components/calendar/YetProjectSpComponent.vue').default);
Vue.component('board', require('./components/calendar/Board.vue').default);
Vue.component('daily-project-pc-component', require('./components/calendar/DailyProjectPcComponent.vue').default);
Vue.component('daily-project-sp-component', require('./components/calendar/DailyProjectSpComponent.vue').default);
Vue.component('project-register-component', require('./components/projects/ProjectRegisterComponent.vue').default);
Vue.component('project-show-component', require('./components/projects/ProjectShowComponent.vue').default);
Vue.component('project-orderer-show-component', require('./components/projects/ProjectOrdererShowComponent.vue').default);
Vue.component('survey-register-component', require('./components/survey/SurveyRegisterComponent.vue').default);
Vue.component('client-project-show-component', require('./components/projects/ClientProjectShowComponent.vue').default);
Vue.component('client-project-report-component', require('./components/projects/ClientProjectReportComponent.vue').default);

// 管理者画面
Vue.component('admin-manager-index-pc-component', require('./components/manage/ManagerIndexPcComponent.vue').default);
Vue.component('admin-manager-index-sp-component', require('./components/manage/ManagerIndexSpComponent.vue').default);
Vue.component('admin-user-list-pc-component', require('./components/manage/UserListPcComponent.vue').default);
Vue.component('admin-user-list-sp-component', require('./components/manage/UserListSpComponent.vue').default);
Vue.component('admin-user-register-component', require('./components/manage/UserRegisterComponent.vue').default);
Vue.component('admin-user-show-component', require('./components/manage/UserShowComponent.vue').default);
Vue.component('admin-user-edit-component', require('./components/manage/UserEditComponent.vue').default);
Vue.component('admin-advertisement-index-pc-component', require('./components/manage/AdvertisementIndexPcComponent.vue').default);
Vue.component('admin-advertisement-index-sp-component', require('./components/manage/AdvertisementIndexSpComponent.vue').default);
Vue.component('admin-advertisement-register-component', require('./components/manage/AdvertisementRegisterComponent.vue').default);
Vue.component('admin-advertisement-show-component', require('./components/manage/AdvertisementShowComponent.vue').default);
Vue.component('admin-advertisement-edit-component', require('./components/manage/AdvertisementEditComponent.vue').default);

Vue.component('modal', require('./components/common/Modal.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store,
    el: '#app',
    data() {
        return {
            isMenuModal: false, // メニューモーダル
            isSearchActive: false, //　検索モーダル
            textbox: "",
        }
    },
    methods: {
        /**
         * clickイベントが発火されたタイミングで、
         * オーバーレイコンテンツを表示するフラグを持つdata(isModalActive)を切り替える
         */
        openItem() {
            this.openModal();
        },
        closeItem() {
            this.closeModal();
        },
        toggleSearch() {
            this.isSearchActive = !this.isSearchActive;
            this.textbox = "";
        },

        /**
        メニューモーダル　nav.blade.php
        **/
        toggleItem() {
            this.isMenuModal = !this.isMenuModal;
        },
        openModal() {
            this.isMenuModal = true;
        },
        closeModal() {
            this.isMenuModal = false;
        },
    }
});

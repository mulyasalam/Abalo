import './bootstrap.js';
import {pi, round} from 'mathjs';
import DarkMode from "vue-dark-mode-switcher";
import NavigatorShare from 'vue-navigator-share'




let r = round(pi, 5); //aufgabe 3 m4
console.log(r);

import articlesearch from "./sitebody.vue";
import newarticle from "./newarticle.vue";
import navigation from "./siteheader.vue";
import ImpressumComponent from "./sitefooter.vue";
import impressum from "./impressum.vue";
import pagination  from "./Pagination.vue";
import {createApp, ref} from 'vue';
createApp({
    components: {
        articlesearch,
        newarticle,
        navigation,
        ImpressumComponent,
        impressum,
        DarkMode,
        NavigatorShare,
        pagination
    },computed: {
        url() {
            return window.location.href;
        },
        title() {
            return document.title;
        }
    },
    methods: {
        onError(err) {
            alert(err);
            console.log(err);
        },
        onSuccess(err) {
            console.log(err);
        },
        async toggleImpressum(){
            this.showImpressum = !this.showImpressum;
        }
    },data(){
        return{
            showImpressum: false,
        };
    }
}).mount('#app');

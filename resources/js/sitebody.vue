<script>
import axios from "axios";
import Pagination from "./Pagination.vue";
import {add} from 'mathjs';
import impressum from "./impressum.vue";

export default{
    props: ['show-impressum'],
    components: {Pagination, impressum},
    data() {

        return {
            search: '',
            articles: [],
            page: 1,
            totalpages: 0,
            perpage: 5,
            items:[],
            userId: '1',
            currentUserId: 5,

        };
    },methods: {
        connectEcho(){
            window.Pusher.logToConsole = true;
            window.Echo.channel('wartung')
                .listen('.wartungsevent', (e) => {
                    alert(e.message);
                })


            let userId = 5; //change according to article
            window.Echo.channel(`verkaufsMeldung.${userId}`)
                .listen('.verkaufs-Meldung', (e) => {
                    console.log('Article sold event received');
                    alert(e.message);
                })
                .error((error) => {
                    console.log('Subscription Error: ', error);
                });
            window.Echo.channel(`OffersEvent`)
                .listen('.Offers-Event', (e) => {
                    console.log('Offers event received');
                    alert(e.message);
                })
                .error((error) => {
                    console.log('offer event Error: ', error);
                });


        },
        changePage(newPage) {

            this.page = newPage;
            this.searchArticles();
        },
        changeItemsPerPage(newItemsPerPage) {
            this.perpage = newItemsPerPage;
            this.searchArticles();
        },
        async searchArticles() {

            if (this.search.length >= 3) {
                try {
                    const response = await axios.get(`/api/articles?search=${this.search}&page=${this.page}&perpage=${this.perpage}`);
                    let data = response.data;
                    this.articles = data.data;
                    this.totalpages = Math.ceil(response.data.total / this.perpage);
                } catch (error) {
                    console.error(error.message);
                }
            } else if(this.search.length == 0) {
                try {
                    const response = await axios.get(`/api/articles?page=${this.page}&perpage=${this.perpage}`);
                    this.articles = response.data.data;
                    this.totalpages = Math.ceil(response.data.total / this.perpage);
                } catch (error) {
                    console.error(error);
                }
            }
        },
        setOffer(articleId){
            axios.post(`/api/articles/${articleId}/offer/1`) // Replace '1' with the actual user ID
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },

        updateArticle(id) {
            window.updateCart(id);
        },
        //addbasket function
        async loadCart() {
            try {
                const response = await axios.get('/api/shoppingcart', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                });
                this.items = response.data;
            } catch (error) {
                console.error('Error loading cart:', error);
            }
        },
        async addProduct(article) {
            try {
                const response = await axios.post('/api/shoppingcart', { article_id: article.id }, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                });
                if (!this.items.find(item => item.id === article.id)) {
                    this.items.push(article);
                }
            } catch (error) {
                console.error('Error adding product:', error);
            }
        },
        removeProduct(item) {
            this.items = this.items.filter(i => i.id !== item.id); // Remove item locally
            this.removeItem(1, item.id); // Remove item from server
        },
        removeAll() {
            this.items.forEach(item => {
                this.removeItem(1, item.id); // Remove each item from server
            });
            this.items = []; // Clear local items array
        },
        removeItem(shoppingCartId, articleId) {
            const payload = {
                article_id: articleId,
                shoppingcartid: shoppingCartId
            };

            console.log('Request payload:', payload);

            fetch(`/api/shoppingcart/${shoppingCartId}/articles/${articleId}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload)
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.error || 'Network response was not ok');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Item removed:', data.message);
                    // Optionally update local state or UI based on successful removal
                })
                .catch(error => {
                    console.error('Error removing item:', error);
                    // Optionally handle error states or UI feedback
                });
        },


        markAsSold(articleId) {

            axios.post(`/api/articles/${articleId}/sold`)
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
    mounted() {
        this.searchArticles();
        this.loadCart();
        this.connectEcho();
    },
    computed: {
        totalPrice() {
            return this.items.reduce((sum, item) => add(sum, item.ab_price ), 0);
        },
    },
};

</script>

<template>
    <impressum v-if="showImpressum"></impressum>
    <div v-else>
    <div class="basket">
        <h2 class="basket__title">My Basket</h2>
        <div class="basket__content">
            <table class="basket__table" ref="basketTable">
                <thead class="basket__thead">
                <tr class="basket__tr">
                    <th class="basket__th">Name</th>
                    <th class="basket__th">Price</th>
                    <th class="basket__th">Action</th>
                </tr>
                </thead>
                <tbody class="basket__tbody">
                <tr v-for="item in items" :key="item.id" class="basket__item">
                    <td class="basket__td">{{ item.ab_name }}</td>
                    <td class="basket__td">{{ (item.ab_price ).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }} €</td>
                    <td class="basket__td basket__td--action">
                        <button class="basket__button" @click="removeProduct(item)">Remove</button>
                    </td>
                </tr>
                </tbody>
                <tfoot class="basket__tfoot">
                <tr class="basket__tr">
                    <td class="basket__td">Total</td>
                    <td class="basket__td">{{ totalPrice.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }} €</td>
                    <td class="basket__td basket__td--action">
                        <button class="basket__button" @click="removeAll">Remove All</button>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>

        <h2 class="search__title">Article Search</h2>
        <input type="text" v-model="search" @input="searchArticles" class="search__input">

        <div class="search__content">
            <table class="search__table">
                <thead class="search__thead">
                <tr class="search__tr">
                    <th class="search__th">ID</th>
                    <th class="search__th">Article</th>
                    <th class="search__th">Description</th>
                    <th class="search__th">Price</th>
                    <th class="search__th">Images</th>
                    <th class="search__th">Created at</th>
                    <th class="search__th">Add to Basket</th>
                    <th class="search__th">Sold</th>
                    <th class="search__th">Offer</th>
                </tr>
                </thead>
                <tbody class="search__tbody">
                <tr v-for="article in articles" :key="article.id" class="search__item">
                    <th class="search__td">{{article.id}}</th>
                    <th class="search__td">{{ article.ab_name }}</th>
                    <td class="search__td">{{ article.ab_description }}</td>
                    <td class="search__td">{{ (article.ab_price).toLocaleString('de-DE', { style: 'currency', currency: 'EUR' }) }} </td>
                    <td class="search__td"><img :src="article.image_url" :alt="article.ab_name" class="search__image"></td>
                    <td class="search__td">{{ article.ab_createdate }}</td>
                    <td class="search__td search__td--center" @click="addProduct(article)"><button class="search__button">+</button></td>
                    <td class="search__td search__td--center" @click="markAsSold(article.id)"><button class="search__button">Sold</button></td>
                    <td class="search__td">
                        <button v-if="article.ab_creator_id === currentUserId" @click="setOffer(article.id)" class="search__button search__button--offer">X</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div id="app">
            <table class="pagination">
                <tbody class="pagination__tbody">
                <tr class="pagination__tr">
                    <pagination :page="page" :totalPages="totalpages" :itemsPerPage="perpage" @page-changed="changePage" @items-per-page-changed="changeItemsPerPage"></pagination>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</template>


<style scoped lang ="scss">
@import "../sass/variables";
@function rem($px) {
    @return #{$px / 16}rem;
}

// Mixins
@mixin border-box {
    border: 1px solid $border-color;
}

@mixin button-style {
    background-color: #9ca3af;
    border: none;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: $button-font-size;
    margin: 4px 2px;
    cursor: pointer;

    &:hover {
        background-color: $button-hover-bg;
    }
}

// Basis-Stile
table {
    width: 100%;
    border-collapse: collapse;

    th, td {
        @include border-box;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: $background-color-light;
    }

    tr:nth-child(even) {
        background-color: $background-color-light;
    }
}

button {
    @include button-style;
}

img {
    width: $img-width;
}

// BEM-Struktur
.basket {
    &__title {
        font-weight: bolder;
    }

    &__content {
        margin-bottom: 20px; // Optional: Abstand zum nächsten Element
    }

    &__table {
        width: 100%;
    }

    &__thead, &__tfoot {
        background-color: $background-color-light; // Optional: Hintergrundfarbe für thead und tfoot
    }

    &__tr, &__th, &__td {
        @include border-box;
        padding: 8px;
        text-align: left;
    }

    &__th {
        background-color: $background-color-light;
    }

    &__td--action {
        text-align: center;
        background-color: $background-color-light;
    }

    &__button {
        @include button-style;
    }
}

.search {
    &__title {
        margin-top: 20px; // Optional: Abstand zum vorherigen Element
    }

    &__input {
        margin-bottom: 20px; // Optional: Abstand zum nächsten Element
        padding: 8px; // Optional: Innenabstand
        width: 30%; // Optional: volle Breite
        box-sizing: border-box; // Optional: Padding und Border werden in die Breite einbezogen
    }

    &__content {
        margin-bottom: 20px; // Optional: Abstand zum nächsten Element
    }

    &__table {
        width: 100%;
        border-collapse: collapse;

        th, td {
            @include border-box;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: $background-color-light;
        }

        tr:nth-child(even) {
            background-color: $background-color-light;
        }
    }

    &__thead, &__tbody {
        // Optional: spezifische Stile für thead und tbody
    }

    &__tr, &__th, &__td {
        @include border-box;
        padding: 8px;
        text-align: left;
    }

    &__image {
        width: $img-width;
    }

    &__td--center {
        text-align: center;
    }

    &__button {
        @include button-style;
    }

    &__button--offer {
        background-color: #ff0000; // Optional: spezifische Farbe für Angebots-Button
    }
}

.pagination {
    &__tbody {
        // Optional: spezifische Stile für tbody
    }

    &__tr {
        // Optional: spezifische Stile für tr
    }
}

// Utility-Klassen
.border {
    @include border-box;
}

.px-2 {
    padding-left: $padding-medium;
    padding-right: $padding-medium;
}

.py-1 {
    padding-top: $padding-small;
    padding-bottom: $padding-small;
}

.w-6 {
    width: $small-width;
}

</style>

<!-- resources/js/components/ArticleForm.vue -->
<template>
    <div class="article-form">
        <h1 class="article-form__title">Artikeleingabe</h1>
        <form class="article-form__form" @submit.prevent="submitForm">
            <input type="hidden" name="_token" :value="csrfToken">

            <div class="article-form__field">
                <input class="article-form__input" type="text" v-model="article.name" placeholder="Name" required>
            </div>
            <div class="article-form__field">
                <input class="article-form__input" type="text" v-model="article.description" placeholder="Beschreibung" required>
            </div>
            <div class="article-form__field">
                <input class="article-form__input" type="number" v-model="article.price" placeholder="Price" min="1" required>
            </div>
            <button class="article-form__button" type="submit">Speichern</button>
        </form>
        <p v-if="responseMessage" :class="{'article-form__response': true, 'article-form__response--error': responseMessageColor === 'red'}">{{ responseMessage }}</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            article: {
                name: '',
                description: '',
                price: null
            },
            responseMessage: '',
            responseMessageColor: 'green'
        };
    },
    methods: {
        async submitForm() {
            try {
                const response = await axios.post('/api/articles', this.article, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                });
                this.responseMessage = response.data;
                this.responseMessageColor = 'green';
            } catch (error) {
                if (error.response) {
                    const responseData = error.response.data;
                    let message = responseData.message + "\n";
                    for (const key in responseData.errors) {
                        message += responseData.errors[key] + "\n";
                    }
                    this.responseMessage = message;
                    this.responseMessageColor = 'red';
                }
            }
        }
    }
};
</script>

<style scoped lang="scss">
.article-form {
    &__title {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    &__form {
        display: flex;
        flex-direction: column;
    }

    &__field {
        margin-bottom: 1rem;
    }

    &__input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }

    &__button {
        padding: 0.75rem;
        font-size: 1rem;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;

        &:hover {
            background-color: #0056b3;
        }
    }

    &__response {
        margin-top: 1rem;
        font-size: 1rem;

        &--error {
            color: red;
        }
    }
}
</style>

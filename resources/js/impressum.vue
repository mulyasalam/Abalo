<script>
export default {
    name: 'Impressum',
}
</script>

<template>
    <div class="impressum">
        <br />
        <br />
        <div class="content">
            <h1 class="content__title" >Impressum</h1>

            <h2 class="adresse">Angaben gem&auml;&szlig; &sect; 5 TMG</h2>
            <p class="adresse__detail">
                Gruppe 304<br />
                Eupenerstra&szlig;e 70<br />
                52066 Aachen
            </p>


            <h2 class="vertreten">Vertreten durch:</h2>
            <p class="vertreten_detail">
                Muhammad Mulya Salam<br/>
                Nathan Mathew Kurnia
            </p>

            <h2 class="contact">Kontakt</h2>
            <p class="contact__detail">
                Telefon: +49 (0) 123 44 55 66<br />
                Telefax: +49 (0) 123 44 55 99<br />
                E-Mail: mustermann@musterfirma.de
            </p>
        </div>
    </div>
</template>


<style scoped lang="scss">
@import "../sass/variables";
@import "../sass/impressum";
</style>

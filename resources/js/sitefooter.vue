<script>
export default {
    emits: ['toggle-impressum'],
    methods: {
        showImpressum() {
            this.$emit('toggle-impressum');
        }
    },
}
</script>

<template>
    <div class="footer">
        <a @click="showImpressum">Impressum</a>
    </div>
</template>

<style scoped lang="scss">
$fonts: Helvetica, sans-serif;
$backcolor: #606C5D;
$hovercolor: #263A29;

.footer{
    list-style-type: none;
    top: 0;
    width: 20%;
    margin-top: 0;
    display: grid;
    font-family: $fonts;
    background-color: $backcolor;
    padding: 0;
    color: white;
    text-align: center;
}
</style>

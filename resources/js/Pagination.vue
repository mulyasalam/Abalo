<script>
export default {
    props: ['page', 'totalPages', 'itemsPerPage'],
    methods: {
        changePage(newPage) {
            if (newPage >= 1 && newPage <= this.totalPages) {
                this.$emit('page-changed', newPage);
            }
        },
        itemsPerPageChanged(event) {
            this.$emit('items-per-page-changed', parseInt(event.target.value));
        },
    }
};
</script>

<template>
    <div>
        <button @click="changePage(page - 1)" :disabled="page === 1">Previous</button>
        <span>{{ page }} of {{ totalPages }}</span>
        <button @click="changePage(page + 1)" :disabled="page === totalPages">Next</button>
        <select id="items-per-page" :value="itemsPerPage" @change="itemsPerPageChanged">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
</template>

<style scoped lang="scss">
$backcolor: #606C5D;
button {
    padding: 10px;
    background-color: $backcolor; /* Green */
    border: none;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

button:disabled {
    background-color: #cccccc; /* Gray */
    cursor: not-allowed;
}

select {
    width: 50px;
    padding: 10px;
    border: none;
    border-radius: 4px;
    background-color: #f1f1f1;
    font-size: 10px;
    text-align: left;
}
</style>

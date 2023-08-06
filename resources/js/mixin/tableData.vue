<template>

</template>

<script>
export default {
    name: "tableData",
    mounted() {
        jQuery( document ).ready(function( $ ) {
            $('.myTable').DataTable( {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.4/i18n/ar.json'
                },
                dom: 'lBfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'print'
                ]
            } );
        });
    }
}
</script>

<style lang="scss" scoped>

</style>

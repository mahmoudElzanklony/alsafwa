<template>

</template>

<script>
export default {
    name: "storage",
    methods:{
        stoageData:function(type,value,url){
            if(type == "set") {
                if(value instanceof Object){
                    localStorage.setItem('item', JSON.stringify(value));
                }else {
                    localStorage.setItem('item', value);
                }
            }else{
                localStorage.setItem('item',null);
            }
            this.$inertia.visit(url);

        },
    }
}
</script>

<style scoped>

</style>

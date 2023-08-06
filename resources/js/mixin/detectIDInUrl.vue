<template>

</template>

<script>
export default {
    name: "detectIDInUrl",
    data:function(){
        return {
            urlID:'',
        }
    },
    mounted() {
        if(window.location.href.split('id=')[1]){
            // there is an id in url
            if($('#'+window.location.href.split('id=')[1]).length > 0) {
                $('#' + window.location.href.split('id=')[1]).css('backgroundColor', '#4899d82b');
                window.scrollTo({
                    top: $('#' + window.location.href.split('id=')[1]).offset().top,
                    behavior: 'smooth',
                })
            }
            // show button at top left
            $('.urlID').show();
            this.urlID = window.location.href.split('id=')[1];
        }else{
            // hide button at top left
            $('.urlID').hide();
        }
    },
}
</script>

<style scoped>

</style>

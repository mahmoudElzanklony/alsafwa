<template>

</template>

<script>

export default {
    name: "errorAjax",
    methods:{
        handleErrorAjax:function (data , target){
            target.find('p.alert-danger').hide();
            if(data.hasOwnProperty('errors')){
                // there are errors
                var inputs = target.find('input:not(.btn),select');
                for(let input of inputs){
                    if(data.errors.hasOwnProperty($(input).attr('name'))){
                        $(input).parent().find('p').html(data['errors'][$(input).attr('name')][0]);
                        $(input).parent().find('p').fadeIn();
                    }
                }
            }else if(data.hasOwnProperty('error_message')){
                // error from server
                target.find('p[name="error_message"]').html(data.error_message);
                target.find('p[name="error_message"]').fadeIn();
            }
        }
    }
}
</script>

<style scoped>

</style>

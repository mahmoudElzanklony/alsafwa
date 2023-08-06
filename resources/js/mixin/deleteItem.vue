<template>

</template>

<script>
export default {
    name: "deleteItem",
    methods:{
        deleteItem:function (id,table){
            var deleted = $(event.target).parent().parent().parent();
            Swal.fire({
                title: 'هل انت متأكد من عمليه المسح',
                text: "انتبه عند عمليه المسح لن تستطيع استرجاع البيانات مره اخري وسيتم مسح اي بيانات اخري مرتبطه بها",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:'الغاء الامر',
                confirmButtonText: 'نعم انا متأكد'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:'/delete',
                        type:'POST',
                        data:{id:id,table:table},
                        success:function (data){
                            deleted.remove();
                            Toast.fire({
                                icon: 'success',
                                title: 'تمت عمليه المسح بنجاح'
                            });
                        }
                    });
                }
            })

        }
    }
}
</script>

<style scoped>

</style>

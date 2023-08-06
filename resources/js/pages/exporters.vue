<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه المصدرين</h2>

            <div class="container mt-5">
                <p class="text-left">
                    <button class="btn btn-outline-primary" @click="item = null" data-toggle="modal" data-target="#saveItem">اضافه مصدر جديد</button>
                </p>
                <div class="overflow-auto">
                    <table class="myTable table table-bordered  table-hover text-center table-striped">
                        <thead>
                        <tr>
                            <td>الرقم التسلسلي</td>
                            <td>اسم المصدر</td>
                            <td>التحكم</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in output" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>

                            <td class="control">
                                <span><i @click="updateItem(item)" data-toggle="modal" data-target="#saveItem" class="ri-edit-2-line"></i></span>
                                <span><i @click="deleteItem(item.id,'exporters')" class="ri-delete-bin-line"></i></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="saveItem" tabindex="-1" role="dialog" aria-labelledby="saveItem" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ item == null ? 'اضافه بيان جديد'
                                :
                                'تعديل بيانات '
                                +
                                item.name
                                }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="role_data" class="form_icons" method="post" @submit.prevent="save_inserted_item" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>الأسم</label>
                                    <input name="name"
                                           class="form-control" :value="item != null  ? item.name:''"
                                           required>
                                    <span><i class="ri-information-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-outline-success" value="حفظ">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
import NavbarComponent from "../components/navbar-component";
import deleteItem from "../mixin/deleteItem";
import errorAjax from "../mixin/errorAjax";
import tableData from "../mixin/tableData";

export default {
    name: "exporters",
    mixins:[deleteItem,errorAjax,tableData],
    components: {NavbarComponent},
    props:['data'],
    data:function (){
        return{
            item:null,
            output:this.data,
        }
    },
    methods:{
        updateItem:function (item){
            this.item = item;
        },
        save_inserted_item:function (){
            var target = $(event.target);
            var form_data = new FormData(event.target);
            if(this.item != null){
                form_data.append('id',this.item.id);
            }
            $.ajax({
                url:'/exporters/save',
                type:'POST',
                data:form_data,
                processData: false,
                contentType: false,
                success:function (data){
                    this.handleErrorAjax(data,target);
                    if(data.hasOwnProperty('success')){
                        this.item = null;
                        this.output = data['success'];
                        Toast.fire({
                            icon: 'success',
                            title: 'تم حفظ البيان بنجاح'
                        });
                        // close modal
                        $('.modal form')[0].reset();
                        $('.modal').modal('hide');
                    }
                }.bind(this)
            });

        }
    },
    created() {
        document.body.style.zoom = "100%";
    }
}
</script>

<style lang="scss" scoped>

.color_show{
    width: 80px;
    height: 30px;
    display: block;
    margin: auto;
    border-radius: 6px;
}
</style>

<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه الشركات </h2>
            <div class="container mt-5">
                <p class="text-left">
                    <button class="btn btn-outline-primary" @click="item = null" data-toggle="modal" data-target="#saveUser">اضافه شركة جديد</button>
                </p>
                <table class="myTable table table-bordered  table-hover text-center table-striped">
                    <thead>
                    <tr>
                        <td>الرقم التسلسلي</td>
                        <td>الأسم</td>
                        <td>اللون</td>
                        <td>التحكم</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="branch in output" :key="branch.id">
                        <td>{{ branch.id }}</td>
                        <td>{{ branch.name }}</td>
                        <td>
                            <span class="color_show" :style="'backgroundColor:'+branch.color"></span>
                        </td>
                        <td class="control">
                            <span><i @click="updateItem(branch)" data-toggle="modal" data-target="#saveUser" class="ri-edit-2-line"></i></span>
                            <span><i @click="deleteItem(branch.id,'companies_types')" class="ri-delete-bin-line"></i></span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="saveUser" tabindex="-1" role="dialog" aria-labelledby="saveUser" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ item == null ? 'اضافه فرع جديد'
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
                            <form name="role_data" class="form_icons" method="post" @submit.prevent="save_user" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>اسم الشركة</label>
                                    <input name="name" class="form-control" :value="item != null  ? item.name:''" required>
                                    <span><i class="ri-information-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>لون الفرع</label>
                                    <input name="color" type="color"
                                           class="form-control" :value="item != null  ? item.color:''"
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
import updateCurrentItem from "../mixin/updateCurrentItem";

export default {
    name: "companies_branches",
    mixins:[deleteItem,errorAjax,tableData,updateCurrentItem],
    components: {NavbarComponent},
    props:['branches'],
    data:function (){
        return{
            item:null,
            output:this.branches,
        }
    },
    created() {
        this.type = document.URL.split('type=')[1];
        document.body.style.zoom = "100%";
    },
    methods:{
        save_user:function (){
            var target = $(event.target);
            var form_data = new FormData(event.target);
            if(this.item != null){
                form_data.append('id',this.item.id);
            }
            $.ajax({
                url:'/breanches/save',
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
                            title: 'تم حفظ الشركة بنجاح'
                        });
                        // close modal
                        $('.modal form')[0].reset();
                        $('.modal').modal('hide');
                    }
                }.bind(this)
            });

        }
    }
}
</script>

<style lang="scss" scoped>
.modal.show .modal-dialog{
    max-width: 55%;
}
.color_show{
    width: 80px;
    height: 30px;
    display: block;
    margin: auto;
    border-radius: 6px;
}
</style>

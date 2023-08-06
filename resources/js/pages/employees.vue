<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه الموظفين </h2>
            <div class="container mt-5">
                <p class="text-left">
                    <button class="btn btn-primary" @click="item = null" data-toggle="modal" data-target="#saveData">اضافه موظف  جديد</button>
                </p>
                <table class="table table-bordered  table-hover text-center table-striped">
                    <thead>
                    <tr>
                        <td>الأسم</td>
                        <td>البريد الالكتروني </td>
                        <td>الدور</td>
                        <td>التحكم</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in output" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role.name }}</td>
                        <td class="control">
                            <span><i @click="updateItem(user)" data-toggle="modal" data-target="#saveData" class="ri-edit-2-line"></i></span>
                            <span><i @click="deleteItem(user.id,'users')" class="ri-delete-bin-line"></i></span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="saveData" tabindex="-1" role="dialog" aria-labelledby="saveData" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ item == null ? 'اضافه موظف جديد'
                                :
                                'تعديل بيانات الموظف '
                                +
                                item.name
                                }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="role_data" class="form_icons" method="post" @submit.prevent="saveData" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>اسم الموظف</label>
                                    <input name="name" class="form-control" :value="item != null  ? item.name:''" required>
                                    <span><i class="ri-user-2-fill"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>البريد الالكتروني</label>
                                    <input name="email" class="form-control" type="email" :value="item != null  ? item.email:''" required>
                                    <span><i class="ri-mail-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>كلمه المرور</label>
                                    <input name="password" type="password" class="form-control" :placeholder="item!= null ? 'اتركها فارغه في حاله عدم رغبتك في التعديل':''"  :required="item == null" value="" autocomplete="off">
                                    <span><i class="ri-lock-password-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>

                                <div class="form-group">
                                    <label>الدور</label>
                                    <select class="form-control" name="role_id" required>
                                        <option value="">اختر الدور المناسب</option>
                                        <option v-for="role in roles" :key="role.id" :value="role.id"  :selected="item!= null && item.role_id == role.id">{{ role.name }}</option>
                                    </select>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="حفظ">
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
import updateCurrentItem from "../mixin/updateCurrentItem";
import errorAjax from "../mixin/errorAjax";
export default {
    name: "employees",
    mixins:[deleteItem,updateCurrentItem,errorAjax],
    components: {NavbarComponent},
    props:['employees','roles'],
    data:function (){
        return{
            item:null,
            output:this.employees,
        }
    },
    methods:{

        saveData:function (){
            var target = $(event.target);
            var form_data = new FormData(event.target);
            if(this.item != null){
                form_data.append('id',this.item.id);
            }
            $.ajax({
                url:'/employees/save',
                type:'POST',
                data:form_data,
                processData: false,
                contentType: false,
                success:function (data){
                    console.log(data);
                    this.handleErrorAjax(data,target);
                    if(data.hasOwnProperty('success')){
                        this.item = null;
                        this.output = data['success'];
                        Toast.fire({
                            icon: 'success',
                            title: 'تمت عمليه الحفظ بنجاح'
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

</style>

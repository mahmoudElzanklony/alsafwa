<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه الصلاحيات </h2>
            <div class="container mt-5">
                <p class="text-left">
                    <button class="btn btn-primary" @click="item = null" data-toggle="modal" data-target="#saveRoleData">اضافه صلاحيه جديده</button>
                </p>
                <table class="table table-bordered  table-hover text-center table-striped">
                    <thead>
                        <tr>
                            <td>الرقم التسلسلي</td>
                            <td>الأسم</td>
                            <td>الرقم القومي</td>
                            <td>رقم الهاتف</td>
                            <td>العنوان</td>
                            <td>الصلاحيات</td>
                            <td>التحكم</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="role in output" :key="role.id">
                            <td>{{ role.name }}</td>
                            <td>
                               <span name="privillage" v-for="p in role['permissions']" :key="p.id">
                                   {{ p.ar_name }}
                               </span>
                            </td>
                            <td class="control">
                                <span><i @click="updateItem(role)" data-toggle="modal" data-target="#saveRoleData" class="ri-edit-2-line"></i></span>
                                <span><i @click="deleteItem(role.id,'roles')" class="ri-delete-bin-line"></i></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="saveRoleData" tabindex="-1" role="dialog" aria-labelledby="saveRoleData" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ item == null ? 'اضافه صلاحيه جديده'
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
                            <form name="role_data" class="form_icons" method="post" @submit.prevent="save_role_permission" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>اسم الدور</label>
                                    <input name="name" class="form-control" :value="item != null  ? item.name:''" required>
                                    <span><i class="ri-user-settings-fill"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group privillages">
                                    <button type="button" class="btn btn-primary selectAll" @click="selectAll">تحديد االكل</button>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 mb-2 text-right" v-for="permission_data in Object.keys(permissions)" :key="permission_data.id">
                                            <p class="lead font-weight-bold">{{ permission_data }}</p>
                                            <div class="input-check mb-2" v-for="permission in permissions[permission_data]" :key="permission.id">
                                                <input type="checkbox" name="privillages[]" :value="permission.id" :checked="item != null && item.permissions.includes(permission.id)">
                                                <span>{{ permission.ar_name }}</span>
                                            </div>
                                        </div>
                                    </div>
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
export default {
    name: "privillages",
    mixins:[deleteItem],
    components: {NavbarComponent},
    props:['roles','permissions'],
    data:function (){
      return{
          item:null,
          output:this.roles,
      }
    },
    methods:{
        selectAll:function(){
            $(event.target).next().find('input').toggleClass('checked');
            for(var input of $(event.target).next().find('input')){
                if($(input).hasClass('checked')){
                    $(input).prop('checked',true);
                }else{
                    $(input).prop('checked',false);
                }
            }
        },
        updateItem:function (item){
            let role = {};
            role['id'] = item.id;
            role['name'] = item.name;
            role['permissions'] = [];
            item.permissions.find(function(p){
                role['permissions'].push(p['id']);
            });
            this.item = role;
            console.log(this.item);
        },

        save_role_permission:function (){
            var target = $(event.target);
            var form_data = new FormData(event.target);
            if(document.role_data.name.value.indexOf("مدير")  >= 0){
                Toast.fire({
                    icon: 'error',
                    title: 'صلاحيات المدير موجوده بالفعل لذا لا تقم بأنشائها من جديد'
                });
            }else{
                if(this.item != null){
                    form_data.append('id',this.item.id);
                }
                $.ajax({
                    url:'/saverole',
                    type:'POST',
                    data:form_data,
                    processData: false,
                    contentType: false,
                    success:function (data){
                        console.log(data);
                        if(data.hasOwnProperty('success')){
                            this.item = null;
                            this.output = data['success'];
                            Toast.fire({
                                icon: 'success',
                                title: 'تم حفظ الدور والصلاحيات بنجاح'
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
}
</script>

<style lang="scss" scoped>
.modal.show .modal-dialog{
    max-width: 55%;
}
input[type="checkbox"]{
    position: relative;
    top: 3px;
    width: 15px;
    height: 15px;
}
table span[name='privillage']{
    padding: 5px 20px;
    border-radius: 10px;
    margin-left: 5px;
    background-color: #e5e5e5;
    display: inline-block;
    margin-bottom: 5px;
}
</style>

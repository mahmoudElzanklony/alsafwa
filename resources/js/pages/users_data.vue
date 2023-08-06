<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه المستخدمين </h2>
            <div class="container mt-5">
                <p class="text-left">
                    <button class="btn btn-outline-primary" @click="item = null" data-toggle="modal" data-target="#saveUser">اضافه مستخدم جديد</button>
                </p>
                <table class="myTable table table-bordered  table-hover text-center table-striped">
                    <thead>
                    <tr>
                        <td>الرقم التسلسلي</td>
                        <td>الأسم</td>
                        <td>البريد الالكتروني</td>
                        <td>رقم الهاتف</td>
                        <td>العنوان</td>
                        <td>الشركات المتاحه</td>
                        <td>المصدرين المتاحين</td>
                        <td>الوجهه المسموح بها</td>

                        <td>التحكم</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in output" :key="user.id" :style="user.type == 'admin' ? {backgroundColor:'#64b5f63b'}:''">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.phone }}</td>
                        <td>{{ user.address }}</td>
                        <td>
                               <span name="privillage"
                                     v-for="(c,index) in user.companies" :key="index"
                                     :style="'color:white; backgroundColor:'+c.company.color"
                               >
                                   {{ c.company.name }}
                               </span>
                        </td>
                        <td>
                               <span name="privillage"
                                     v-for="(c,index) in user.exporters" :key="index"
                               >
                                   {{ c.exporter.name }}
                               </span>
                        </td>
                        <td>
                               <span name="privillage"
                                     v-for="(c,index) in user.destinations" :key="index"
                               >
                                   {{ c.destination.name }}
                               </span>
                        </td>
                        <td class="control">
                            <span><i @click="updateItem(user)" data-toggle="modal" data-target="#saveUser" class="ri-edit-2-line"></i></span>
                            <span><i @click="deleteItem(user.id,'users')" class="ri-delete-bin-line"></i></span>
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
                                {{ item == null ? 'اضافه مستخدم جديد'
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
                                    <label>اسم المستخدم</label>
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
                                    <label>الهاتف</label>
                                    <input name="phone" type="number" class="form-control" :value="item != null  ? item.phone:''" required>
                                    <span><i class="ri-user-2-fill"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>العنوان</label>
                                    <input name="address" class="form-control" :value="item != null  ? item.address:''" required>
                                    <span><i class="ri-user-2-fill"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group" v-if="item == null || item.type != 'admin'">
                                    <label>التحكم</label>
                                    <select class="form-control" name="control" required>
                                        <option>اختر سماحية  المستخدم من القدره علي التحكم في البيانات</option>
                                        <option value="1" :selected="item != null && item.control == 1">نعم</option>
                                        <option value="0" :selected="item != null && item.control == 0">لا</option>
                                    </select>
                                    <p class="alert alert-danger"></p>
                                </div>

                                <div class="form-group privillages"  v-if="item == null || item.type != 'admin'">
                                    <h4 class="mb-2">الشركات</h4>
                                    <button type="button" class="btn btn-primary selectAll" @click="selectAll">تحديد االكل</button>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="input-check mb-2 ml-4" v-for="(company,index) in companies" :key="index">
                                                <input type="checkbox" name="compaines[]" :value="company.id" :checked="item != null && item.companies.map((e) => e.company_id ).includes(company.id)">
                                                <span>{{ company.name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group privillages"  v-if="item == null || item.type != 'admin'">
                                    <h4 class="mb-2">المصدرين</h4>
                                    <button type="button" class="btn btn-primary selectAll" @click="selectAll">تحديد االكل</button>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="input-check mb-2 ml-4" v-for="(exporter,index) in exporters" :key="index">
                                            <input type="checkbox" name="exporters[]" :value="exporter.id" :checked="item != null && item.exporters.map((e) => e.exporter_id ).includes(exporter.id)">
                                            <span>{{ exporter.name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group privillages"  v-if="item == null || item.type != 'admin'">
                                    <h4 class="mb-2">الوجهة</h4>
                                    <button type="button" class="btn btn-primary selectAll" @click="selectAll">تحديد االكل</button>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="input-check mb-2 ml-4" v-for="(destination,index) in destinations" :key="index">
                                            <input type="checkbox" name="destinations[]" :value="destination.id" :checked="item != null && item.destinations.map((e) => e.destination_id ).includes(destination.id)">
                                            <span>{{ destination.name }}</span>
                                        </div>
                                    </div>
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
    name: "users_data",
    mixins:[deleteItem,errorAjax,tableData],
    components: {NavbarComponent},
    props:['users','companies','destinations','exporters'],
    data:function (){
        return{
            item:null,
            output:this.users,
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
            this.item = item;
            console.log(this.item);
        },

        save_user:function (){
            var target = $(event.target);
            var form_data = new FormData(event.target);
            if(this.item != null){
                form_data.append('id',this.item.id);
            }
            $.ajax({
                url:'/users/saveuser',
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
                            title: 'تم حفظ المستخدم بنجاح'
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
    display: inline-block;
    margin-bottom: 5px;
}
</style>

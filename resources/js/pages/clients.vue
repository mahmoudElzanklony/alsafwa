<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه العملاء </h2>
            <div class="container mt-5">
                <p class="text-left">
                    <button class="btn btn-primary" @click="item = null" data-toggle="modal" data-target="#saveData">اضافه عميل  جديد</button>
                </p>
                <table class="table table-bordered  table-hover text-center table-striped">
                    <thead>
                    <tr>
                        <td>الرقم التسلسلي</td>
                        <td>الأسم</td>
                        <td>الرقم القومي</td>
                        <td>رقم الهاتف</td>
                        <td>العنوان</td>
                        <td>التحكم</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="client in output" :key="client.id">
                        <td>{{ client.id }}</td>
                        <td>{{ client.name }}</td>
                        <td>{{ client.national_id }}</td>
                        <td>{{ client.phone }}</td>
                        <td>{{ client.address }}</td>
                        <td class="control">
                            <span v-if="edit_client"><i @click="updateItem(client)" data-toggle="modal" data-target="#saveData" class="ri-edit-2-line"></i></span>
                            <span data-toggle="modal" data-target="#saveDataService"><i @click="updateItem(client)"  class="ri-add-line"></i></span>
                            <inertia-link :href="'/clients-services?id='+client.id"><i class="ri-eye-line"></i></inertia-link>
                            <span v-if="delete_client"><i @click="deleteItem(client.id,'clients')" class="ri-delete-bin-line"></i></span>

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
                                {{ item == null ? 'اضافه عميل جديد'
                                :
                                'تعديل بيانات العميل '
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
                                    <label>اسم العميل</label>
                                    <input name="name" class="form-control" :value="item != null  ? item.name:''" required>
                                    <span><i class="ri-user-3-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>الرقم القومي</label>
                                    <input name="national_id" class="form-control" type="number" :value="item != null  ? item.national_id:''" required>
                                    <span><i class="ri-bank-card-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>رقم الهاتف</label>
                                    <input name="phone" class="form-control" type="number" :value="item != null  ? item.phone:''" required>
                                    <span><i class="ri-phone-fill"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>العنوان</label>
                                    <input name="address" class="form-control" :value="item != null  ? item.address:''" required>
                                    <span><i class="ri-map-pin-line"></i></span>
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

            <!-- Modal -->
            <div class="modal fade" id="saveDataService" tabindex="-1" role="dialog" aria-labelledby="saveData" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example">
                                اضافه خدمه جديده
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="role_data" class="form_icons" method="post" @submit.prevent="saveDataRequest" enctype="multipart/form-data">
                                <div class="form-group" style="display: none">
                                    <label>اسم العميل</label>
                                    <input type="hidden" name="client_id" :value="item != null ? item.id : ''">
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>اسم الخدمه </label>
                                    <select class="form-control" name="service_id" @change="changeService" required>
                                        <option value="">اختر الخدمه المناسبه</option>
                                        <option v-for="s in services" :key="s.id" :value="s.id">{{ s.name }} {{ s.type != '' ? ' وهي تابعه ل'+s.type:'' }}</option>
                                    </select>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>السعر</label>
                                    <input name="price" type="number" class="form-control"  required>
                                    <span><i class="ri-money-euro-circle-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>

                                <div class="form-group">
                                    <label>اسم الوحدات المحليه</label>
                                    <select class="form-control" name="neighborhood_id" required>
                                        <option value="">اختر الوحده المناسبه</option>
                                        <option v-for="neighborhood in neighborhoods" :key="neighborhood.id" :value="neighborhood.id">{{ neighborhood.name }}</option>
                                    </select>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>الملاحظات</label>
                                    <textarea name="wanted" class="form-control" required></textarea>
                                    <span><i class="ri-file-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>تاريخ التسليم</label>
                                    <input class="form-control" name="receipt_date" type="date">
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
    name: "clients",
    mixins:[deleteItem,updateCurrentItem,errorAjax],
    components: {NavbarComponent},
    props:['clients','edit_client','delete_client','services','neighborhoods'],
    data:function (){
        return{
            item:null,
            output:this.clients,
            client_id:null,
        }
    },
    methods:{
        changeService:function(){
            var price = this.services.filter(function(e){ return e.id == $(event.target).val() })[0].price;
            $(event.target).parent().next().find('input').val(price);
        },
        saveData:function (){
            var target = $(event.target);
            var form_data = new FormData(event.target);
            if(this.item != null){
                form_data.append('id',this.item.id);
                if(this.edit_client == false){
                    Toast.fire({
                        icon: 'error',
                        title: 'ليس لديك صلاحيه للقيام بالتعديل'
                    });
                    return false;
                }
            }
            $.ajax({
                url:'/clients/save',
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
        },

        saveDataRequest:function (){
            var target = $(event.target);
            var form_data = new FormData(event.target);

            $.ajax({
                url:'/servicerequest/save',
                type:'POST',
                data:form_data,
                processData: false,
                contentType: false,
                success:function (data){
                    console.log(data);
                    this.handleErrorAjax(data,target);
                    if(data.hasOwnProperty('success')){
                        this.item = null;
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
@import "resources/scss/variables";
table .control span{
    margin-left: 4px;
}
table .control span:nth-of-type(2){
    color: $dark_blue;
}
table .control span:nth-of-type(2){
    color: $black;
}
</style>

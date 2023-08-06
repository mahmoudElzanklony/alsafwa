<template>

    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه الوثائق والتقارير التابعه ل {{ type }}   </h2>
            <div class="container mt-5">
                <p class="text-left">
                    <button class="btn urlID btn-primary" @click="item = null" data-toggle="modal" data-target="#saveData">اضافه وثيقه  جديده</button>

                </p>
                <table class="table table-bordered  table-hover text-center table-striped">
                    <thead>
                    <tr>
                        <td>اسم الخدمه</td>
                        <td>اسم العميل</td>
                        <td>الوثيقه</td>
                        <td>تاريخ التسليم</td>
                        <td>تاريخ الاستلام</td>
                        <td>التحكم</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="service in output" :key="service.id" :id="service.service_request.id">
                        <td>{{ service.service_request.service.name }}</td>
                        <td>{{ service.service_request.client.name }}</td>
                        <td v-if="service.engineer_id == null">
                            <a :href="'/documents/'+service.document_file">اضغط هنا</a>
                        </td>
                        <td>{{ new Date(service.delivery_date).toLocaleDateString() }}</td>
                        <td>{{ new Date(service.receipt_date).toLocaleDateString() }}</td>
                        <td class="control">
                            <span><i @click="updateItem(service)" data-toggle="modal" data-target="#saveData" class="ri-edit-2-line"></i></span>
                            <span><i @click="deleteItem(service.id,'documents')" class="ri-delete-bin-line"></i></span>
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
                                {{ item == null ? 'اضافه ملف  جديد'
                                :
                                'تعديل بيانات ملف  خدمه '
                                +
                                item.service_request.service.name
                                +
                                ' التابعه ل '
                                +
                                item.service_request.client.name
                                }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="role_data" class="form_icons" method="post" @submit.prevent="saveData" enctype="multipart/form-data">
                                <input type="hidden" name="service_request_id" v-if="item != null" :value="item != null  ? item.service_request_id:''">
                                <input type="hidden" name="service_request_id" v-else :value="urlID">
                                <div class="form-group">
                                    <label>التقرير</label>
                                    <input name="document_file" type="file" class="form-control" :required="item == null" >
                                    <span><i class="ri-file-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>تاريخ الاستلام</label>
                                    <input class="form-control" name="delivery_date" :value="item != null  ? item.delivery_date:''" type="date" required>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group">
                                    <label>تاريخ التسليم</label>
                                    <input class="form-control" name="receipt_date" :value="item != null  ? item.receipt_date:''"  type="date" required>
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
import detectIDInUrl from "../mixin/detectIDInUrl";
export default {
    name: "documents",
    mixins:[deleteItem,updateCurrentItem,errorAjax,detectIDInUrl],
    components: {NavbarComponent},
    props:['documents','type'],
    data:function (){
        return{
            item:null,
            output:this.documents,
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
                url:'/documents/save/?Uid='+this.urlID,
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
@import "resources/scss/variables";
tr{
    td{
        span{
            color:$blue !important;
        }
    }
}
</style>

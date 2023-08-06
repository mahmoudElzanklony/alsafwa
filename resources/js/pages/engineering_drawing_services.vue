<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه معاينه الرسم الهندسي الخاصه ب  {{ type }}   </h2>
            <div class="container mt-5">
                <p class="text-left">
                    <button class="btn urlID btn-primary" @click="item = null" data-toggle="modal" data-target="#saveData">اضافه رسم هندسي جديد</button>
                </p>
                <table class="table table-bordered  table-hover text-center table-striped">
                    <thead>
                    <tr>
                        <td>اسم الخدمه</td>
                        <td>اسم العميل</td>
                        <td v-if="type == 'تصميم داخلي'">التصميم المبدأي</td>
                        <td v-else>المهندس</td>
                        <td v-if="type == 'تصميم داخلي'">مراجعه العميل</td>
                        <td v-if="type == 'تصميم داخلي'">التصميم النهائي</td>
                        <td>التاريخ</td>

                        <td>التحكم</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="service in output" :key="service.id" :id="service.service_request.id">
                        <td>{{ service.service_request.service.name }}</td>
                        <td>{{ service.service_request.client.name }}</td>
                        <td v-if="type == 'تصميم داخلي'">{{ service.prototype_design }}</td>
                        <td v-if="type == 'تصميم داخلي'">{{ service.client_review }}</td>
                        <td v-if="type == 'تصميم داخلي'">{{ service.final_design }}</td>
                        <td v-else>
                            {{  service.engineer_id == null ? '':engineers.filter(function(e){ return e.id == service.engineer_id})[0]['name'] }}
                        </td>
                        <td>{{ service.date }}</td>

                        <td class="control" v-if="type == 'تصميم داخلي'">
                            <span><i @click="updateItem(service)" data-toggle="modal" data-target="#saveData" class="ri-edit-2-line"></i></span>
                            <span><i @click="deleteItem(service.id,'internal__engineering__drawings')" class="ri-delete-bin-line"></i></span>
                        </td>
                        <td class="control" v-else>
                            <span><i @click="updateItem(service)" data-toggle="modal" data-target="#saveData" class="ri-edit-2-line"></i></span>
                            <span><i @click="deleteItem(service.id,'engineering__drawings')" class="ri-delete-bin-line"></i></span>
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
                                {{ item == null ? 'اضافه رسم هندسي جديد '
                                :
                                'تعديل بيانات رسم هندسي لخدمه '
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
                            <form  name="role_data" class="form_icons" method="post" @submit.prevent="saveData" enctype="multipart/form-data">
                                <input type="hidden" name="service_request_id" v-if="item != null" :value="item != null  ? item.service_request_id:''">
                                <input type="hidden" name="service_request_id" v-else :value="urlID">
                                <div class="form-group" v-if="type != 'تصميم داخلي'">
                                    <label>اسم المهندس</label>
                                    <select class="form-control" name="engineer_id" required>
                                        <option value="">اختر المهندس المناسب</option>
                                        <option v-for="eng in engineers" :key="eng.id" :value="eng.id" :selected="item!= null && item.engineer_id == eng.id">{{ eng.name }}</option>
                                    </select>
                                    <p class="alert alert-danger"></p>
                                </div>
                                <div class="form-group" v-else>
                                    <div class="form-group">
                                        <label>التصميم المبدأي</label>
                                        <textarea name="prototype_design" class="form-control" type="number" :value="item != null  ? item.prototype_design:''" required>{{ item != null  ? item.prototype_design:'' }}</textarea>
                                        <span><i class="ri-image-2-line"></i></span>
                                        <p class="alert alert-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <label>مراجعه العميل</label>
                                        <textarea name="client_review" class="form-control" type="number" :value="item != null  ? item.client_review:''" required>{{ item != null  ? item.client_review:'' }}</textarea>
                                        <span><i class="ri-image-edit-line"></i></span>
                                        <p class="alert alert-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <label>التصميم النهائي</label>
                                        <textarea name="final_design" class="form-control" type="number" :value="item != null  ? item.final_design:''" required>{{ item != null  ? item.final_design:'' }}</textarea>
                                        <span><i class="ri-image-add-line"></i></span>
                                        <p class="alert alert-danger"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>التاريخ</label>
                                    <input class="form-control" name="date" type="date" :value="item != null ? item.date:''" required>
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
    name: "engineering_drawing_services",
    mixins:[deleteItem,updateCurrentItem,errorAjax,detectIDInUrl],
    components: {NavbarComponent},
    props:['engineering_drawing_services','type','engineers'],
    data:function (){
        return{
            item:null,
            output:this.engineering_drawing_services,
        }
    },

    methods:{

        saveData:function (){
            var target = $(event.target);
            var form_data = new FormData(event.target);
            var url = null;
            if(this.item != null){
                form_data.append('id',this.item.id);

            }
            if (this.type != 'تصميم داخلي'){
                url = '/engineering-draw/save/?Uid='+this.urlID;
            }else{
                url = '/internal-engineering-draw/save/?Uid='+this.urlID;
            }

            $.ajax({
                url:url,
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

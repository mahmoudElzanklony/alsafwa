<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه المحذوفات </h2>
            <div class="container mt-5">

                <div class="data overflow-auto">
                <table class="myTable table table-bordered  table-hover text-center table-striped">
                    <thead>
                        <tr v-if="type == 'users'">
                            <td>الرقم التسلسلي</td>
                            <td>الأسم</td>
                            <td>البريد الالكتروني</td>
                            <td>رقم الهاتف</td>
                            <td>العنوان</td>
                            <td>التحكم</td>
                        </tr>
                        <tr v-else-if="type == 'info'">
                            <td>الرقم التسلسلي</td>
                            <td>اسم المستخدم</td>
                            <td>اسم الشركه</td>
                            <td>الصنف</td>
                            <td>المنشأ</td>
                            <td>المصدر</td>
                            <td>رقم الفاتورة</td>
                            <td>قيمة الفاتورة</td>
                            <td>ACID</td>
                            <td>رقم الحاوية</td>
                            <td>الوجهة</td>
                            <td>الخط</td>
                            <td>بوليصة</td>
                            <td>المركب</td>
                            <td>وصول</td>
                            <td>التعليمات</td>
                            <td>سماح</td>
                            <td>رفع</td>
                            <td>46</td>
                            <td>الطلب</td>
                            <td>الكشف</td>
                            <td>وزن</td>
                            <td>عدد</td>
                            <td>ملاحظات عامة</td>
                            <td>تاريخ الصرف</td>
                            <td>مطابقه</td>
                            <td>منتهي</td>
                            <td>التحكم</td>
                        </tr>
                        <tr v-else>
                            <td>الرقم التسلسلي</td>
                            <td>الأسم</td>
                            <td>اللون</td>
                            <td>التحكم</td>
                        </tr>
                    </thead>
                    <tbody v-if="type == 'users'">
                        <tr  v-for="user in output" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.phone }}</td>
                            <td>{{ user.address }}</td>
                            <td class="control">
                                <span><i @click="restore(user.id,'users')" class="ri-refresh-line"></i></span>
    <!--                            <span><i @click="deleteItem(user.id,'users')" class="ri-delete-bin-line"></i></span>-->
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-if="type == 'info'">
                        <tr v-for="item in output" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.user.name }}</td>
                        <td>{{ item.company.name }}</td>
                        <td>{{ item.item }}</td>
                        <td>{{ item.country }}</td>
                        <td>{{ item.source }}</td>
                        <td>{{ item.bill_number }}</td>
                        <td>{{ item.bill_value }}</td>
                        <td>{{ item.ACID }}</td>
                        <td>{{ item.number_container }}</td>
                        <td>{{ item.destination }}</td>
                        <td>{{ item.line }}</td>
                        <td>{{ item.policy }}</td>
                        <td>{{ item.vehicle }}</td>
                        <td>{{ item.arrived }}</td>
                        <td v-if="item.instructions_status == 'مستلم'">{{ item.instructions_status }}</td>
                        <td v-else></td>
                        <td>{{ item.allowed }}</td>
                        <td>{{ item.lifting_status }}</td>
                        <td>{{ item.forty_six_number }}</td>
                        <td>{{ item.request_number }}</td>
                        <td>{{ item.statement_status }}</td>
                        <td>{{ item.weight }}</td>
                        <td>{{ item.number_data }}</td>
                        <td>{{ item.notes }}</td>
                        <td>{{ item.exchange_date }}</td>
                        <td>{{ item.matching_status }}</td>
                        <td>{{ item.status == 1 ?'منتهي':'غير منتهي' }}</td>
                        <td class="control">
                            <span><i @click="restore(item.id,'info_datas')" class="ri-refresh-line"></i></span>
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-else-if="type == 'branches'">
                        <tr v-for="branch in output" :key="branch.id">
                            <td>{{ branch.id }}</td>
                            <td>{{ branch.name }}</td>
                            <td>
                                <span class="color_show" :style="'backgroundColor:'+branch.color"></span>
                            </td>
                            <td class="control">
                                <span><i @click="restore(branch.id,'companies_types')" class="ri-refresh-line"></i></span>
                            </td>
                        </tr>
                    </tbody>

                </table>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import NavbarComponent from "../components/navbar-component";
import errorAjax from "../mixin/errorAjax";
import tableData from "../mixin/tableData";

export default {
    name: "deletes_data",
    mixins:[errorAjax,tableData],
    components: {NavbarComponent},
    props:['data','columns'],
    data:function (){
        return{
            item:null,
            output:this.data,
            type:'',
        }
    },
    created() {
        this.type = document.URL.split('type=')[1];
        document.body.style.zoom = "100%";
    },
    methods:{
        restore:function (id,table){
            var deleted = $(event.target).parent().parent().parent();
            $.ajax({
                url:'/restore-data',
                type:'POST',
                data:{id:id,table:table},
                success:function (data){
                    deleted.remove();
                    Toast.fire({
                        icon: 'success',
                        title: 'تمت عملية الاسترجاع بنجاح'
                    });
                }.bind(this)
            });
        },
        updateItem:function (item){
            this.item = item;
            console.log(this.item);
        },

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
.color_show{
    width: 80px;
    height: 30px;
    display: block;
    margin: auto;
    border-radius: 6px;
}
</style>

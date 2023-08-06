<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه الرسومات الاحصائيه </h2>
            <div class="container mt-5">
                <form @submit.prevent="filterData" class="d-flex justify-content-center align-items-center">
                    <select class="form-control ml-2" name="year" required>
                        <option value="">اختر السنه</option>
                        <option :value="new Date().getFullYear()">{{ new Date().getFullYear() }}</option>
                        <option v-for="d in 15" :value="Number(new Date().getFullYear()) - d">{{ Number(new Date().getFullYear()) - d }}</option>
                    </select>
                    <select name="status" class="form-control ml-2">
                        <option value="">اختر الحالة</option>
                        <option value="1">منتهيه</option>
                        <option value="0">غير منتهية</option>
                    </select>
                    <select name="company_id" class="form-control ml-2">
                        <option value="">اختر الفرع</option>
                        <option v-for="(i,index) in companies" :key="index" :value="i['id']">
                            {{ i['name'] }}
                        </option>
                    </select>
                    <input class="form-control btn btn-primary" type="submit" value="بحث">
                </form>

                <line-chart :chart-data="data"></line-chart>
            </div>


        </div>
    </div>
</template>


<script>
import NavbarComponent from "../components/navbar-component";
export default {
    name: "charts_data",
    props:['filter_data','companies'],
    components: { NavbarComponent},
    created() {
        console.log(this.data);
        this.updateChart(Object.values(this.filter_data));
        document.body.style.zoom = "100%";

    },

    data:function(){
        return {
            data: {
                data: Object.values(this.filter_data)
            },
        }
    },

    methods:{
        updateChart:function(data){
            setTimeout(() => {
                this.data =Object.values(data);
                console.log(this);
                console.log(this.data);
            }, 1000)
        },
        filterData:function (){
            var target = $(event.target);
            var form_data = new FormData(event.target);
            var output = [];
            $.ajax({
                url:'/chart/filter',
                type:'POST',
                data:form_data,
                processData: false,
                async:false,
                contentType: false,
                success:function (data){
                    output = Object.values(data);
                }.bind(this)
            });
            this.data = output;
        }

    },
}
</script>

<style lang="scss" scoped>
form{
    max-width: 500px;
    margin: 20px auto;
    input:not(:last-of-type){
        margin-left: 10px;
    }
}
</style>

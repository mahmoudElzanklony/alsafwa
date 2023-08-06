<template>
    <div class="data_rows_data">
        <navbar-component></navbar-component>
        <div class="page-content info-data-style">


        <div class="container">
                <h2 v-if="false" class="main-title" style="font-size: 20px">
                    <span>مرحبا بك في صفحه البيانات</span>
                    <span  v-if="status == 1">المنتهيه</span>
                    <span  v-else>غير المنتهيه</span>
                </h2>
                <div class="header-controls d-flex justify-content-between titles">
                    <div class="d-flex">
                        <p class="text-center">
                            <a  href="?status=1" class="btn btn-outline-primary mr-5"> منتهية</a>
                            <a  href="?status=0" class="btn btn-outline-secondary ml-4"> غير منتهية</a>
                        </p>
                        <p>
                            <a class="btn btn-outline-success"
                                          :href="'?status='+status+'&sort=id'">الاضافه</a>
                            <a
                                class="btn btn-outline-primary"
                                :href="'?status='+status+'&sort=updated_at'">التعديل</a>
                            <a
                                class="btn btn-outline-warning ml-3"
                                :href="'?status='+status+'&sort=arrived'">الوصول</a>
                            <a
                                class="btn btn-outline-info"
                                :href="'?status='+status+'&sort=one'">اولي</a>
                            <a
                                class="btn btn-outline-dark"
                                :href="'?status='+status+'&sort=two'">ثانيه</a>
                            <a
                                class="btn btn-outline-secondary"
                                :href="'?status='+status+'&sort=three'">ثالثه</a>
                        </p>
                    </div>
                    <div>
                        <button class="btn btn-primary" @click="zoom_in">+</button>
                        <span>{{ screen_zoom }}%</span>
                        <button class="btn btn-danger" @click="zoom_out">-</button>
                    </div>
                    <div>
                        <p class="text-left d-inline-block">
                            <button v-if="$page.props.user_personal_data.type == 'admin' || $page.props.user_personal_data.control == 1" class="btn btn-outline-primary" @click="updateItem(null,0)" data-toggle="modal" data-target="#saveItem">اضافه بيان جديد</button>
                        </p>
                        <p class="text-left d-inline-block">
                            <button v-if="$page.props.user_personal_data.type == 'admin' || $page.props.user_personal_data.control == 1" class="btn btn-outline-warning"  data-toggle="modal" data-target="#print_columns">طباعه</button>
                        </p>
                        <p class="text-left d-inline-block">
                            <button  class="btn btn-outline-dark" @click="refresh">تحديث البيانات</button>
                        </p>
                    </div>
                </div>

                <p class="alert alert-info text-right mt-2" style="display:none;">
                    اذا ارد تظليل صف قم بالضغط علي اي خليه لتظليل الصف بلون معين ان اردت الغاء التظليل قم بالضغط عليه مره لاخري لالغاء التظليل
                </p>
                <div class="overflow-auto">
                    <table class="myTable table table-bordered  table-hover text-center table-striped"


                    >
                        <!--

                        :style="[ item['matching_status'] != null ?
                         {backgroundColor: 'rgb(94 53 177 / 17%)'}: // purple
                         item['status'] == 1 ?
                          {backgroundColor: '#00000063'}: // black
                         item['instructions_status'] != null ?
                          {backgroundColor: '#c5c1c14f'}: // gray
                          item['number_container'] != null ?
                           {backgroundColor: '#e8f5e9'} : // green
                           {backgroundColor: '#d414063b'} // red
                         ]"

                        -->
                    <thead style="background-color: black">
                        <tr>
                        <td>التسلسلي</td>
                        <td v-show="false">اسم المستخدم</td>
                        <td>اسم الشركه</td>
                        <td>الصنف</td>
                        <td>المنشأ</td>
                        <td>المصدر</td>
                        <td>رقم الفاتورة</td>
                        <td>قيمة الفاتورة</td>
                        <td>عدد</td>
                        <td>وزن</td>
                        <td>ACID</td>
                        <td>اذن الاستيراد</td>
                        <td>الوجهة</td>
                        <td>رقم الحاوية</td>
                        <td>الخط</td>
                        <td>بوليصة</td>
                        <td>المركب</td>
                        <td>وصول</td>
                        <td>سماح</td>
                        <td>التعليمات</td>
                        <td>رفع</td>
                        <td>46</td>
                        <td>الطلب</td>
                        <td>الكشف</td>
                        <td>ملاحظات عامة</td>
                        <td>تاريخ الصرف</td>
                        <td v-show="status == 1">مطابقه</td>
                        <td v-show="false">منتهي</td>
                        <td v-show="false">تاريخ التعديل</td>
                        <td v-if="$page.props.user_personal_data.type == 'admin'">التحكم</td>
                        <td v-else-if="$page.props.user_personal_data.control == 1">التحكم</td>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="(item,index) in output" :key="index"
                        :id="'row_'+index"
                        :style="[ (item['company_id'] == null || item['item'] == null || item['country_id'] == null || item['exporter_id'] == null || item['bill_number'] == null || item['bill_value'] == null || item['number_data'] == null || item['weight'] == null || item['ACID'] == null || item['permission'] == null || item['destination_id'] == null ) ?

                          {backgroundColor: '#FFE566'}: // yellow first step
                         (item['number_container'] == null || item['line'] == null || item['policy'] == null || item['vehicle'] == null || item['arrived'] == null || item['allowed'] == null || item['instructions_status'] == null || item['lifting_status'] == null)?
                          {backgroundColor: '#00184582'}: // blue second step
                          item['status'] == 1 ?
                           {backgroundColor: '#222'} : // black
                           item['matching_status'] != null ? '':
                           {backgroundColor: '#61A5C2'} // three step
                         ]"
                    >

                        <td :id="'id_'+item['id']" style="font-weight: bold">{{ item.id }}</td>
                        <td v-show="false" :id="'user_'+item['id']" style="color:green; font-weight:bold;">{{ item.user.name }}</td>
                        <td :id="'company_'+item['id']" style="color:blue; font-weight:bold;">
                            {{ item.company_id != null ? item.company.name:'' }}
                        </td>
                        <td :id="'item_'+item['id']" style="color:coral; font-weight: bold">{{ item.item }}</td>
                        <td :id="'country_'+item['id']" style="color:cornflowerblue; font-weight: bold">
                            {{ item.country_id != null ? item.country.name:'' }}
                        </td>
                        <td :id="'exporter_'+item['id']" style="color:darkmagenta;font-weight:bold;">
                            {{ item.exporter_id != null ? item.exporter.name : null }}
                        </td>
                        <td :id="'bill_number_'+item['id']" style="color:darkred; font-weight:bold;">
                            {{ item.bill_number }}
                        </td>
                        <td :id="'bill_value_'+item['id']" style="color:darkgreen;font-weight:bold;">{{ item.bill_value }}</td>

                        <td :id="'number_data_'+item['id']" style="color:goldenrod; font-weight: bold">{{ item.number_data }}</td>
                        <td :id="'weight_'+item['id']" style="color:cornflowerblue; font-weight: bold">{{ item.weight }}</td>
                        <td :id="'ACID_'+item['id']" style="font-weight: bold">{{ item.ACID }}</td>
                        <td :id="'permission_'+item['id']" style="color:hotpink;font-weight:bold;">{{ item.permission }}</td>
                        <td :id="'destination_'+item['id']" style="color:purple; font-weight: bold">
                            {{ item.destination_id != null ? item.destination.name : '' }}
                        </td>
                        <td :id="'number_container_'+item['id']" style="color:cornflowerblue; font-weight: bold">{{ item.number_container }}</td>

                        <td :id="'line_'+item['id']" style="color:coral; font-weight: bold">{{ item.line }}</td>
                        <td :id="'policy_'+item['id']" style="color:green; font-weight:bold;">{{ item.policy }}</td>
                        <td :id="'vehicle_'+item['id']" style="color:darkred; font-weight:bold;">{{ item.vehicle }}</td>
                        <td :id="'arrived_'+item['id']" style="color:cornflowerblue; font-weight: bold">{{ item.arrived }}</td>

                        <td :id="'allowed_'+item['id']" style="color:darkgreen;font-weight:bold;">{{ item.allowed }}</td>
                        <td :id="'instructions_status_'+item['id']" style="font-weight: bold">{{ item.instructions_status }}</td>
                        <td :id="'lifting_status_'+item['id']" style="color:darkblue; font-weight: bold">{{ item.lifting_status }}</td>
                        <td :id="'forty_six_number_'+item['id']" style="color:#086868; font-weight: bold">{{ item.forty_six_number }}</td>
                        <td :id="'request_number_'+item['id']" style="color:darkred; font-weight:bold;">{{ item.request_number }}</td>
                        <td :id="'statement_status_'+item['id']">{{ item.statement_status }}</td>

                        <td :id="'notes_'+item['id']" style="color:purple; font-weight: bold">{{ item.notes }}</td>
                        <td :id="'exchange_date_'+item['id']" style="color:coral; font-weight: bold">{{ item.exchange_date }}</td>
                        <td v-show="status == 1" :id="'matching_status_'+item['id']" style="color:darkgreen;font-weight:bold;">{{ item.matching_status }}</td>
                        <td v-show="false" :id="'status_'+item['id']" style="color:cornflowerblue; font-weight: bold">
                            {{ item.status == 1 ?'منتهي':'غير منتهي' }}</td>
                        <td v-show="false" :id="'updated_at_'+item['id']" style="color:coral; font-size: 10px; font-weight: bold">
                            {{ new Date(item.updated_at).toLocaleString() }}</td>
                        <td class="control" v-if="$page.props.user_personal_data.type == 'admin' || $page.props.user_personal_data.control == 1">
                            <span><i @click="updateItem(item,index)" data-toggle="modal" data-target="#saveItem" class="ri-edit-2-line"></i></span>
                            <span><i @click="deleteItem(item.id,'info_datas')" class="ri-delete-bin-line"></i></span>
                        </td>
                    </tr>
                    </tbody>

                    <tfoot style="display: none">
                    <tr>
                    <tr>
                        <td>التسلسلي</td>
                        <td v-show="false">اسم المستخدم</td>
                        <td>اسم الشركه</td>
                        <td>الصنف</td>
                        <td>المنشأ</td>
                        <td>المصدر</td>
                        <td>رقم الفاتورة</td>
                        <td>قيمة الفاتورة</td>
                        <td>عدد</td>
                        <td>وزن</td>
                        <td>ACID</td>
                        <td>اذن الاستيراد</td>
                        <td>الوجهة</td>
                        <td>رقم الحاوية</td>
                        <td>الخط</td>
                        <td>بوليصة</td>
                        <td>المركب</td>
                        <td>وصول</td>
                        <td>سماح</td>
                        <td>التعليمات</td>
                        <td>رفع</td>
                        <td>46</td>
                        <td>الطلب</td>
                        <td>الكشف</td>
                        <td>ملاحظات عامة</td>
                        <td>تاريخ الصرف</td>
                        <td v-if="status == 1">مطابقه</td>
                        <td v-show="false">منتهي</td>
                        <td v-show="false">تاريخ التعديل</td>
                        <td v-if="$page.props.user_personal_data.type == 'admin'">التحكم</td>
                    </tr>
                    </tfoot>
                </table>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="print_columns" tabindex="-1" role="dialog" aria-labelledby="saveItem" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="print_columns_model">
                                طباعه البيانات
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="select_columns_before_print">
                                <div class="form-group privillages">
                                    <h4 class="mb-2">اسماء الاعمدة</h4>
                                    <button type="button" class="btn btn-primary selectAll" @click="selectAll">تحديد االكل</button>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="input-check mb-2 ml-4"
                                             v-for="(column,index) in columns" :key="index">
                                            <input type="checkbox" name="columns[]" :value="index">
                                            <span>{{ column }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" value="حفظ" >
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
            <div class="modal fade" id="saveItem" tabindex="-1" role="dialog" aria-labelledby="saveItem" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ item == null ? 'اضافه بيان جديد'
                                :
                                'تعديل بيانات '
                                +
                                item.item
                                }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="role_data" class="form_icons" method="post" @submit.prevent="save_user" enctype="multipart/form-data">
                             <div class="row">
                                <div class="col-xl-4 col-md-6 col-12" name="company_id_item_country_id_destination_id_exporter_id_bill_number_bill_value_ACID_permission_weight_number_data">
                                    <div class="inputs-data">
                                        <div class="form-group searchable">
                                            <label>اسم الشركة</label>

                                            <input type="hidden" name="company_id"
                                                   :value="item != null && item.company_id != null ?
                                            item.company_id:''"
                                            >
                                            <input
                                                v-if="$page.props.user_personal_data.type == 'admin'"
                                                class="form-control" search="true"
                                                :value="item != null && item.company_id != null ?
                                            companies.find((e) =>{return e['id'] == item.company_id})['name']:''"
                                                placeholder="ابحث عن شركة...">

                                            <input v-else
                                                   class="form-control" search="true"
                                                   :value="item != null && item.company_id != null ?
                                            companies.find((e) =>{return e['company']['id'] == item.company_id})['company']['name']:''"
                                                   placeholder="ابحث عن شركة..."
                                            >

                                            <ul  v-if="$page.props.user_personal_data.type == 'admin'">
                                                <li v-for="(e,index) in companies" :key="index" :value="e.id" :selected="item != null && item.company_id != null &&  e.id == item.company_id">{{ e.name }}</li>
                                            </ul>

                                            <ul  v-else>
                                                <li v-for="(e,index) in companies" :key="index"
                                                    :value="e.company.id"
                                                    :selected="item != null && item.company_id != null &&  e.company.id == item.company_id">{{ e.company.name }}</li>
                                            </ul>




                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>الصنف</label>
                                            <textarea name="item"
                                                      class="form-control" :value="item != null  ? item.item:''"
                                                      >{{ item != null  ? item.item:'' }}</textarea>
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group searchable">
                                            <label>المنشا</label>

                                            <input type="hidden" name="country_id"
                                                   :value="item != null && item.country_id != null ?
                                            item.country_id:''"
                                            >
                                            <input  class="form-control" search="true"
                                                    :value="item != null && item.country_id != null ?
                                            countries.find((e) =>{return e['id'] == item.country_id})['name']:''"
                                                    placeholder="ابحث عن منشأ...">
                                            <ul>
                                                <li v-for="(e,index) in countries" :key="index" :value="e.id" :selected="item != null && item.country_id != null &&  e.id == item.country_id">{{ e.name }}</li>
                                            </ul>

                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group searchable">
                                            <label>المصدر</label>
                                            <input type="hidden" name="exporter_id"
                                                   :value="item != null && item.exporter_id != null ?
                                            item.exporter_id:''"
                                            >
                                            <input  class="form-control" search="true"
                                                    :value="item != null && item.exporter_id != null ?
                                            exporters.find((e) =>{return e['id'] == item.exporter_id})['name']:''"
                                                    placeholder="ابحث عن مصدر...">
                                            <ul>
                                                <li v-for="(e,index) in exporters" :key="index" :value="e.id" :selected="item != null && item.exporter_id != null &&  e.id == item.exporter_id">{{ e.name }}</li>
                                            </ul>
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>رقم الفاتورة</label>
                                            <input name="bill_number"
                                                   class="form-control" :value="item != null  ? item.bill_number:''"
                                                   >
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>قيمه الفاتورة</label>
                                            <input name="bill_value"
                                                   class="form-control" :value="item != null  ? item.bill_value:''"
                                                   >
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>العدد</label>
                                            <input name="number_data"
                                                   class="form-control" type="number" :value="item != null  ? item.number_data:''"
                                            >
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>الوزن</label>
                                            <input name="weight"
                                                   class="form-control" type="number" :value="item != null  ? item.weight:''"
                                            >
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>

                                        <div class="form-group">
                                            <label>ACID</label>
                                            <input name="ACID" @blur="checknumbersize"
                                                   class="form-control" type="number" :value="item != null  ? item.ACID:''"
                                                   >
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>اذن الاستيراد</label>
                                            <textarea name="permission"
                                                      class="form-control"  :value="item != null  ? item.permission:''"
                                                      >{{ item != null  ? item.permission:'' }}</textarea>
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group searchable">
                                            <label>الواجهة</label>

                                            <input type="hidden" name="destination_id"
                                                   :value="item != null && item.destination_id != null ?
                                                item.destination_id:''"
                                            >
                                            <input  class="form-control"
                                                    v-if="$page.props.user_personal_data.type == 'admin'"
                                                    search="true"
                                                    :value="item != null && item.destination_id != null ?
                                                destinations.find((e) =>{return e['id'] == item.destination_id})['name']:''"
                                                    placeholder="ابحث عن واجهه...">

                                            <input  class="form-control"
                                                    v-else
                                                    search="true"
                                                    :value="item != null && item.destination_id != null ?
                                                user_destinations.find((e) =>{return e['destination']['id'] == item.destination_id})['destination']['name']:''"
                                                    placeholder="ابحث عن واجهه...">


                                            <ul v-if="$page.props.user_personal_data.type == 'admin'">
                                                <li v-for="(e,index) in destinations" :key="index" :value="e.id" :selected="item != null && item.destination_id != null &&  e.id == item.destination_id">{{ e.name }}</li>
                                            </ul>

                                            <ul v-else>
                                                <li v-for="(e,index) in user_destinations" :key="index"
                                                    :value="e.destination.id" :selected="item != null && item.destination_id != null &&  e.id == item.destination_id">{{ e.destination.name }}</li>
                                            </ul>


                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>



                                    </div>

                                    </div>



                                <div class="col-xl-4 col-md-6 col-12" name="number_container_line_policy_vehicle_arrived">
                                    <div class="inputs-data">

                                        <div class="form-group">
                                            <label>رقم الحاوية</label>
                                            <textarea name="number_container"
                                                      class="form-control" :value="item != null  ? item.number_container:''"
                                                      >{{ item != null  ? item.number_container:'' }}</textarea>
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>الخط</label>
                                            <input name="line"
                                                   class="form-control" :value="item != null  ? item.line:''"
                                                   >
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>بوليصة</label>
                                            <input name="policy"
                                                   class="form-control"  :value="item != null  ? item.policy:''"
                                                   >
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>المركب</label>
                                            <input name="vehicle"
                                                   class="form-control" :value="item != null  ? item.vehicle:''"
                                                   >
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                        <label>وصول</label>
                                        <input name="arrived"
                                               class="form-control" type="date" :value="item != null  ? item.arrived:''"
                                               >
                                        <p class="alert alert-danger"></p>
                                    </div>
                                    </div>
                                </div>


                                <div class="col-xl-4 col-md-6 col-12" name="instructions_status_allowed_lifting_status_forty_six_number_request_number_statement_status_notes_exchange_date_matching_status_status">
                                    <div class="inputs-data">
                                        <div class="form-group">
                                            <label>سماح</label>
                                            <input name="allowed"
                                                   class="form-control" :value="item != null  ? item.allowed:''"
                                            >
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>التعليمات</label>
                                            <select name="instructions_status"
                                                    class="form-control"
                                                    :value="item != null  ? item.instructions_status:''"
                                                    >
                                                <option value="">اختر الحالة المناسبة</option>
                                                <option value="تعليمات"
                                                        :selected="item != null &&  item.instructions_status == 'تعليمات'">تعليمات</option>
                                                <option value="اصل" :selected="item != null &&  item.instructions_status == 'اصل'">اصل</option>
                                                <option value="مستلم" :selected="item != null &&  item.instructions_status == 'مستلم'">مستلم</option>
                                            </select>
                                            <p class="alert alert-danger"></p>
                                        </div>

                                        <div class="form-group">
                                            <label>رفع</label>
                                            <select name="lifting_status"
                                                    class="form-control"
                                                    :value="item != null  ? item.lifting_status:''"
                                                    >
                                                <option value="">اختر الحالة المناسبة</option>
                                                <option value="نعم"
                                                        :selected="item != null &&  item.lifting_status == 'نعم'">نعم</option>
                                                <option value="لا" :selected="item != null &&  item.lifting_status == 'لا'">لا</option>

                                            </select>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>46</label>
                                            <input name="forty_six_number"
                                                   class="form-control" type="number" :value="item != null  ? item.forty_six_number:''"
                                                   >
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>الطلب</label>
                                            <input name="request_number"
                                                   class="form-control" type="number" :value="item != null  ? item.request_number:''"
                                                   >
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>الكشف</label>
                                            <select name="statement_status"
                                                    class="form-control"
                                                    :value="item != null  ? item.statement_status:''"
                                                    >
                                                <option value="">اختر الحالة المناسبة</option>
                                                <option value="تم الكشف"
                                                        :selected="item != null && item.statement_status == 'تم الكشف'">تم الكشف</option>
                                                <option value="الكشف اليوم"
                                                        :selected="item != null &&  item.statement_status == 'الكشف اليوم'"
                                                >الكشف اليوم</option>

                                                <option value="جاهزة"
                                                        :selected="item != null && item.statement_status == 'جاهزة'"
                                                >جاهزة</option>

                                                <option value="غير مستعدة"
                                                        :selected="item != null && item.statement_status == 'غير مستعدة'"
                                                >غير مستعدة</option>

                                            </select>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>ملاحظات عامه</label>
                                            <textarea name="notes"
                                                      class="form-control"  :value="item != null  ? item.notes:''">{{ item != null ? item.notes : ''}}</textarea>
                                            <span><i class="ri-information-line"></i></span>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>تاريخ الصرف</label>
                                            <input name="exchange_date"
                                                   :value="exchange_date_val"
                                                   @keyup="updateExchangeDate"
                                                   class="form-control"
                                            >
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>مطابقه</label>
                                            <select name="matching_status"
                                                    class="form-control"
                                                    :value="item != null  ? item.matching_status:''"
                                                    >
                                                <option value="">اختر الحالة المناسبة</option>
                                                <option value="نعم"
                                                        :selected="item != null &&  item.matching_status == 'نعم'">نعم</option>

                                                <option value="لا"
                                                        :selected="item != null &&  item.matching_status == 'لا'">لا</option>

                                            </select>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                        <div class="form-group" v-if="false">
                                            <label>منتهي</label>
                                            <select name="status" class="form-control" >
                                                <option value="">اختر الحالة المناسبة</option>
                                                <option value="1" :selected="item != null && item.status == 1">منتهي</option>
                                                <option value="0" :selected="item != null && item.status == 0">غير منتهي</option>
                                            </select>

                                            <p class="alert alert-danger"></p>
                                        </div>

                                    </div>
                                </div>
                             </div>
                                <div class="form-group">
                                    <input type="submit" class="btn w-100 btn-success" value="حفظ">
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

export default {
    name: "info_data",
    mixins:[deleteItem,errorAjax],
    components: {NavbarComponent},
    props:['data','companies','user_destinations','destinations','countries','exporters'],
    data:function (){
        return{
            item:null,
            output:this.data,
            status:0,
            exchange_date_val:'',
            current_index:0,
            current_url:document.URL,
            tableObj:null,
            columns:[
                'التسلسلي',
                'اسم المستخدم',
                'اسم الشركه',
                'الصنف',
                'المنشأ',
                'المصدر',
                'رقم الفاتورة',
                'قيمة الفاتورة',
                'عدد',
                'وزن',
                'ACID',
                'اذن الاستيراد',
                'الواجهه',
                'رقم الحاوية',
                'الخط',
                'بوليصة',
                'المركب',
                'وصول',
                'سماح',
                'التعليمات',
                'رفع',
                '46',
                'الطلب',
                'الكشف',
                'ملاحظات عامة',
                'تاريخ الصرف',
                'مطابقه',
                'منتهي',
                'تاريخ التعديل',

            ],
            screen_zoom:null,
        }
    },
    computed:{

    },
    mounted() {


        this.screen_zoom = Number(document.body.style.zoom.replace('%',''));



        $('.myTable thead tr td').each(function () {
            var title = $(this).text();
            $(this).html('<input style="font-size: 27px" title="'+title+'" class="form-control" type="text" placeholder="' + title + '" />');

            /*if(title == 'مطابقه' || title == 'منتهي' || title == 'التحكم' || title == 'عدد' ||
                title == 'الرقم التسلسلي' || title == 'اسم المستخدم' || title == 'اسم الشركه'
                || title == 'وزن' ||  title == 'رفع' || title == 'المنشأ' || title == 'رقم الفاتورة' ||
                title == 'رقم الحاوية' || title == 'بوليصة' ||
                title ==  'التعليمات' || title == 'سماح' || title == 'الطلب' || title == 'الوجهة'){
                $(this).attr('width','80px');
                $(this).removeAttr('style');
                console.log($(this).css('width','80px'));
                $(this).html('<input style="width:80px;"  class="form-control" type="text" placeholder="' + title + '" />');
            }

            else if (title ==  'قيمة الفاتورة' || title == 'اذن الاستيراد') {
                $(this).html('<input style="width:110px;"  class="form-control" type="text" placeholder="' + title + '" />');
            }else{
                $(this).html('<input style="width:150px;"  class="form-control" type="text" placeholder="' + title + '" />');
            }*/
        });


        $.noConflict(true);
        var table = null;
        if(document.URL.split('sort=')[1] != undefined){
            if(document.URL.split('sort=')[1] == 'updated_at'){
                 table = $('.myTable').DataTable({
                    columnDefs: [ { targets: "_all" , orderable: false} ],
                    order: [[ 28, 'desc' ]],
                });
            }else if(document.URL.split('sort=')[1] == 'arrived'){
                 table = $('.myTable').DataTable({
                    order: [[ 15, 'asc' ]],
                     columnDefs: [{
                         targets: "_all",
                         orderable: false
                     }]
                });
            }else if(document.URL.split('sort=')[1] == 'one' || document.URL.split('sort=')[1] == 'two' || document.URL.split('sort=')[1] == 'three'){
                table = $('.myTable').DataTable({
                    order: [[ 2, 'asc' ]],
                    columnDefs: [{
                        targets: "_all",
                        orderable: false
                    }]
                });
            }else{
                table = $('.myTable').DataTable({
                    order: [[ 0, 'desc' ]],
                    columnDefs: [{
                        targets: "_all",
                        orderable: false
                    }]
                });
            }
        }else{
            table = $('.myTable').DataTable({
                order: [[ 0, 'desc' ]],
                columnDefs: [{
                    targets: "_all",
                    orderable: false
                }]
            });
        }




        // Apply the search
        table.columns().every( function () {
            var that = this;

            $( 'input', this.header() ).on( 'keyup change', function () {
                that
                    .search( this.value )
                    .draw();
            } );
        } );
        this.tableObj = table;
        setTimeout(()=>{
            global.jQuery = require('jquery');
            var $ = global.jQuery;
            window.$ = $;
        },1500)


        // add event click on every td
        $('table').on('click','tbody tr td:not(:last-of-type)',function(){
            if($(this).attr('id').split('_').length >= 3){
                var attribute_name_to_be_updated = $(this).attr('id').split('_');
                attribute_name_to_be_updated.pop();
                attribute_name_to_be_updated = attribute_name_to_be_updated.join('_');
            }else {
                var attribute_name_to_be_updated = $(this).attr('id').split('_')[0];
            }
            console.log(attribute_name_to_be_updated);

            // check stage attrbite exist
            for(let box of document.querySelectorAll('form[name="role_data"] .row > div')){
                if(box.getAttribute('name').indexOf(attribute_name_to_be_updated) >= 0){
                    box.style.display = 'block';
                    box.className = 'col-12';
                    console.log(box.children[0].children);
                    for(let input of box.children[0].children){
                        if($(input).find('input,textarea,select').attr('name').indexOf(attribute_name_to_be_updated)>=0){
                            input.style.display = 'block';
                        }else {
                            input.style.display = 'none';
                        }
                    }
                }else{
                    box.style.display = 'none';
                }
            }
            var id = $(this).parent().find('td:first-of-type').html();
            var data_to_updated = window.$vm.$inertia.page.props.data.find(function(e){return e.id == id});
            window.$vm.item = data_to_updated;
            $('#saveItem').modal('show');
            $(this).parent().toggleClass('color_tr');
            if(window.$vm.item != null) {
                window.$vm.exchange_date_val = window.$vm.item.exchange_date;
            }
        })


        // set width of search at table
        var input = document.querySelectorAll('table.dataTable thead input');
        for(let i=0; i<input.length; i++){
            if(input[i].title == 'ACID' || input[i].title == 'سماح'){
             input[i].setAttribute('size',50);
            }else if(input[i].title == 'رقم الحاوية'){
              input[i].setAttribute('size',30);
            }else if(input[i].title == 'بوليصة'){
                input[i].setAttribute('size',input[i].getAttribute('placeholder').length + 15);
            }else if(input[i].title == 'الكشف'){
                input[i].setAttribute('size',input[i].getAttribute('placeholder').length + 30);
            } else{
            input[i].setAttribute('size',input[i].getAttribute('placeholder').length + 25);
            }
        }
    },
    created() {

        window.$vm = this;

        this.column_sort = "[["+this.column_number+",'DESC']]";

        if(document.URL.split('?status=')[1] != undefined){
            if(parseFloat(document.URL.split('?status=')[1]) == 1){
                this.status = 1;
            }else{
                this.status = 0;
            }
        }else{
            this.$inertia.visit('?status=0');
            // منتهيه
            var status = 1;
        }

        document.body.style.zoom = "35%";

    },
    methods:{
        updateItem:function (item,current_index){
            console.log(item);
            console.log(current_index);
            this.item = item;
            for(var box_content of document.querySelectorAll('form[name="role_data"] .row > div')){
                box_content.className = 'col-xl-4 col-md-6 col-12';
                box_content.style.display = 'block';
                $(box_content).find('div,input,select,textarea').css('display','block');
            }
            if(this.item != null) {
                this.exchange_date_val = this.item.exchange_date;
            }
            this.current_index = current_index;
        },
        checknumbersize:function (){
           if(event.target.value.length != 19){
               Toast.fire({
                    icon:'error',
                    title:'لابد ان يكون ال ACID مكون من 19 رقم',
               });
               $(event.target).parent().parent().find('input[type="submit"]').attr('disabled','disabled');
           }else{
               $(event.target).parent().parent().find('input[type="submit"]').removeAttr('disabled');
           }
        },
        updateExchangeDate:function (){
           /* console.log(event.target.value);
          this.exchange_date_val = event.target.value;*/
        },
        save_user:function (){
            var com = this;
            var target = $(event.target);
            var form_data = new FormData(event.target);

            if(this.$page.props.user_personal_data.type != 'admin'){
                // employee
                if(document.role_data.company_id.value == ''){
                    /*Toast.fire({
                        icon:'error',
                        title:'من فضلك اختر شركه لهذا البيان',
                    })*/
                    alert('من فضلك اختر شركه لهذا البيان');
                    return false;
                }
                if(document.role_data.destination_id.value == ''){
                    /*Toast.fire({
                        icon:'error',
                        title:'من فضلك اختر واجهةة لهذا البيان',
                    })*/
                    alert('من فضلك اختر واجهةة لهذا البيان');
                    return false;
                }
                if(document.role_data.country_id.value == ''){
                    /*Toast.fire({
                        icon:'error',
                        title:'من فضلك اختر منشأ لهذا البيان',
                    })*/
                    alert('من فضلك اختر واجهه لهذا البيان');
                    return false;
                }
                if(document.role_data.exporter_id.value == ''){
                    /*Toast.fire({
                        icon:'error',
                        title:'من فضلك اختر مصدر لهذا البيان',
                    })*/
                    alert('من فضلك اختر مصدر لهذا البيان');
                    return false;
                }
            }



            if(this.item != null){
                form_data.append('id',this.item.id);
            }
            if(document.URL.split('?status=')[1] != undefined){
                var status = document.URL.split('?status=')[1];
            }else{
                // منتهيه
                var status = 1;
            }
            form_data.append('status_url',status);

            $.ajax({
                headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
                },
                url:'/infodata/save',
                type:'POST',
                data:form_data,
                processData: false,
                contentType: false,
                beforeSend: function(){
                    Toast.fire({
                        icon: 'info',
                        title: 'من فضلك انتظر حتي يتم اكتمال التحميل'
                    });
                },
                success:function (data){
                    this.handleErrorAjax(data,target);
                    if(data.hasOwnProperty('success')){

                        // close modal
                        $('.modal form')[0].reset();
                        $('.modal').modal('hide');


                       /* $.noConflict(true);
                        let table = $('.myTable').DataTable();*/
                        var table = com.tableObj
                        console.log(table);
                    /*    new_data.push(current_row_column_values[current_row_column_values.length-1]);
                        console.log(data['success'])
                        console.log(new_data);
                        table.row('#row_'+this.current_index).data(new_data).draw();*/

                        console.log(data);
                        if(data['id_status'] != null && data['success']['exchange_date'] != null  && data['success']['exchange_date'].split('/')[1] != undefined){
                            document.querySelector('#id_'+data['id_status']).parentElement.remove();
                        }
                        // check if status is update
                        else if(data['id_status'] != null) {



                            var index = this.output.indexOf(this.output.find((e)=>{
                                return e['id'] == data['id_status']
                            }));
                            this.output[index] = data['success']


                            for(let property in data['success']){
                                if(typeof data['success'][property] !='object' &&
                                    property.indexOf('created_at') == -1 &&  property.indexOf('updated_at') == -1){
                                    if(property.indexOf('id') == -1) {
                                        if(property == 'status'){
                                            /*if(data['success'][property] == 1){
                                                table.cell('#'+property+'_'+this.item['id']).data(' منتهي').draw()
                                            }else{
                                                table.cell('#'+property+'_'+this.item['id']).data('غير منتهي').draw()
                                            }*/
                                        }else {
                                           console.log(document.querySelector('#'+property+'_'+this.item['id']));
                                           console.log('#'+property+'_'+this.item['id']);
                                            table.cell('#'+property+'_'+this.item['id'])
                                                .data(data['success'][property]).draw(false)
                                        }
                                    }else{
                                        if(property == 'id'){

                                        }else {
                                            var new_prop = property.replace('_id', '');
                                            if(typeof data['success'][new_prop] == "object"){
                                                var cell_val = data['success'][new_prop]['name'];
                                            }else{
                                                var cell_val = data['success'][new_prop];
                                            }
                                            console.log(property);
                                            console.log(new_prop);
                                            console.log('#'+new_prop+'_'+this.item['id']);
                                            table.cell('#'+new_prop+'_'+this.item['id'])
                                                .data(cell_val).draw(false)
                                        }
                                    }
                                }
                                //    console.log(data['success'][property]);
                            }


                            // = data['success'];
                        }else{
                           // this.output.push(data['success']);
                        }
                        Toast.fire({
                            icon: 'success',
                            title: 'تم حفظ البيان بنجاح'
                        });
                        this.current_index = 0;
                        this.item = null;
                        /*setTimeout((e)=>{
                            com.$inertia.visit(document.URL);
                           // window.location = document.URL
                        },1500);*/
                    }
                }.bind(this)
            });

        },
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
        select_columns_before_print(){
           // $('form input[type="checkbox"]:checked');
            var mywindow = window.open('', 'PRINT');

            mywindow.document.write('<html><head<title>Elsawfa 2009</title>');
            mywindow.document.write('</head><body style="direction: rtl; padding: 25px;"><h1 style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px"><span>تقرير عن احصائيات البيانات</span><span>التاريخ : '+new Date().toLocaleString()+'</span></h1><table style="width: 100%; max-width: 100%; border-collapse:collapse margin-bottom: 1rem;"><thead><tr>');
            for(let input of $('form input[type="checkbox"]:checked')){

                mywindow.document.write('<td style="text-align: center; font-weight: bold;">'+$('table tfoot tr td:not(:last-of-type)').eq(input.value).html()+'</td>');
            }

            mywindow.document.write('</tr></thead><tbody>');


            for(let tr of $('table tbody tr')){
                mywindow.document.write('<tr>');
                for(let input of $('form input[type="checkbox"]:checked')){
                    console.log(input);
                    mywindow.document.write('<td style="padding: 0.75rem; vertical-align: top; text-align: center; border-top: 1px solid #dee2e6;">'+$(tr).find('td').eq(input.value).html()+'</td>');
                }
                mywindow.document.write('</tr>');

            }

            mywindow.document.write('</tbody>');

            mywindow.document.write('</table></body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();
        },
        print_paper:function(){

        },
        refresh:function(){
            window.location = document.URL
        },
        zoom_in:function(){
            this.screen_zoom += 5;
            document.body.style.zoom = Number(document.body.style.zoom.replace('%','')) + 5 + '%';
        },
        zoom_out:function(){
            if(this.screen_zoom > 10) {
                this.screen_zoom -= 5;
                document.body.style.zoom = Number(document.body.style.zoom.replace('%', '')) - 5+'%';
            }else{
                Toast.fire({
                    icon:'error',
                    title:'لا تستطيع عمليه الزوم اوت اكثر من ذلك',
                })
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.modal.show .modal-dialog{
    max-width: 70%;
}
.page-content{
    padding-top: 0px;
}
table{
    tbody{
        tr{
            td{
                font-size: 33px;
                word-break: break-word;
                padding-right: 3px;
                padding-left: 3px;
                input{
                    margin: 0px;
                }
            }
        }
    }
}
.container{
    width:100%;
    max-width: 100%;
}
.color_show{
    width: 80px;
    height: 30px;
    display: block;
    margin: auto;
    border-radius: 6px;
}
h2{
    &::before{
        display: none;
    }
    &::after{
        display: none;
    }
}
.titles{

    a{
        font-size: 20px;
    }
}
.header-controls{
    p{
        margin-bottom: 0px;
    }
}
.color_tr{
    background-color: darkcyan !important;
}
table.dataTable{
    width:100% !important;
}
.info-data-style{
    padding: 0px;
    >div:first-of-type{
        padding: 0px;
    }
}

.modal{
    label,input,select,textarea,li,span,.modal-header h5,.btn{
        font-size: 37px;
    }
    .form-group{
        margin-bottom: 23px;
    }
    .form_icons .form-group > span{
        top:72px;
    }
}
@media print {


}
</style>

<template>
    <div>
        <div v-show = "!isUpdated">
            資料更新中
        </div>
        <div v-show = "isUpdated && !isSubmit">
            <p class="selection-title">店別：</p>
            <store-data :shouldSubmit="isSubmit" />
            <p class="selection-title">課程：</p>
            <ClassNameDataList :shouldSubmit="isSubmit"/>
            <p class="selection-title">星期：</p>
            <WeekDay :shouldSubmit="isSubmit"/>
            <p class="selection-title">老師：</p>
            <teacher-data :shouldSubmit="isSubmit"/>
            <input type="button" value="送出" @click="submit">
         </div>
        <div v-show = "isSubmit">
            <Result/>
            <input type="button" value="重試" @click="retry">

        </div>
    </div>
</template>

<script>
    import ClassNameDataList from "./ClassNameDataList";
    import StoreData from "./StoreData"
    import TeacherData from "./TeacherData";
    import WeekDay from "./WeekDay";
    import Result from "./Result";

    export default {
        data(){
            return{
                isUpdated:false,
                isSubmit:false,
            }
        },
        mounted () {
            axios
                .get('http://localhost/api/getIsUpdated')
                .then(response => (this.isUpdated = response.data))
                .catch(function (error) {
                    console.log(error);
                });
        },
        components: {
            ClassNameDataList, StoreData, TeacherData,WeekDay,Result
        },
        methods:{
            submit(){
                this.$data.isSubmit=true;
            },
            retry(){
                this.$data.isSubmit=false;
            }
        }
    }

</script>

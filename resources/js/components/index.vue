<template>
    <div>
        <div v-show = "!isUpdated">
            資料更新中
        </div>
        <div v-show = "isUpdated && !isSubmit">
            <store-data :shouldSubmit="isSubmit" />
            <ClassNameDataList :shouldSubmit="isSubmit"/>
            <WeekDay :shouldSubmit="isSubmit"/>
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

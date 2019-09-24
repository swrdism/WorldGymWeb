<template>
    <div>
        <store-data/>
        <ClassNameDataList/>
        <WeekDay/>
        <teacher-data/>
    </div>
</template>

<script>
    import Updating from './Updating'
    import ClassNameDataList from "./ClassNameDataList";
    import StoreData from "./StoreData"
    import TeacherData from "./TeacherData";
    import WeekDay from "./WeekDay";
    export default {
        components: {
            Updating, ClassNameDataList, StoreData, TeacherData,WeekDay
        }
    }

</script>

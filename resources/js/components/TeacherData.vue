<template>

    <div v-if="teacherData">

        <span v-for="teacher in teacherData">
            <input
                type="checkbox"
                :id="teacher.name"
                :value="teacher.name"
                v-model="selectedTeacher"
            >
            <label :for="teacher.name">{{teacher.name}}</label>
        </span>
    </div>

</template>

<script>

    const axios = require('axios');
    export default {
        props:['shouldSubmit'],
        data () {
            return {
                teacherData:[],
                selectedTeacher:[]
            }
        },
        mounted () {
            axios
                .get('http://localhost/api/getTeacherDataList')
                .then(response => (this.teacherData = response.data))
                .catch(function (error) {
                    console.log(error);
                });
        },
        watch:{
            shouldSubmit:function () {
                if(this.shouldSubmit) {
                    this.$root.bus.$emit('selectedTeacher', this.selectedTeacher);
                }else{
                    this.selectedTeacher=[];
                }
            }
        }

    }


</script>


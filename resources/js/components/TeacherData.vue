<template>

    <div v-if="teacherData">

        <span v-for="name in teacherData">
            <input
                type="checkbox"
                :id="name"
                :value="name"
                v-model="teacher"
            >
            <label :for="name">{{name}}</label>
        </span>
        <p>{{teacher}}</p>
    </div>

</template>

<script>

    const axios = require('axios');
    export default {
        data () {
            return {
                rawData:null,
                teacher:[]
            }
        },
        mounted () {
            axios
                .get('http://localhost/api/getTeacherDataList')
                .then(response => (this.rawData = response.data))
                .catch(function (error) {
                    console.log(error);
                });
        },
        computed:{
            teacherData:{
                get()
                {
                    if (this.rawData !== null) {
                        let obj = [];
                        this.rawData.forEach(({name}) => {
                            obj.push(name);
                        })
                        return obj;
                    }else{
                        return null;
                    }
                }
            }
        }
    }


</script>


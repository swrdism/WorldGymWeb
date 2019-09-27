<template>

    <div v-if="answer">
        <table>

        <tr v-for="ans in answer">
            <td>{{ans.city + ans.storeName}}</td>
            <td>{{ans.name+'（'+ ans.category +'）'}}</td>
            <td>{{ans.teacher}}</td>
            <td>{{ans.day}}</td>
            <td>{{ans.startTime.toString()}}</td>
            <td>{{ans.endTime.toString()}}</td>
        </tr>
        </table>

    </div>
    <div v-else>
        沒有課程符合您輸入的條件
    </div>
</template>

<script>
    const axios = require('axios');

    export default {
        name: 'result',
        data () {
            return {
                classData:[],

                storeId:[],
                teacher:[],
                weekday:[],
                class:[]
            }
        },
        mounted () {
            axios
                .get('http://localhost/api/getWorldGymClassList')
                .then(response => (this.classData = response.data))
                .catch(function (error) {
                    console.log(error);
                });
        },
        created() {
            this.$root.bus.$on('selectedStore', e=>{
                this.storeId=[];
                e.forEach( e => {
                    this.storeId.push(e.storeId);
                } );
            });
            this.$root.bus.$on('selectedTeacher', e=>{
                this.teacher = e;
            });
            this.$root.bus.$on('selectedWeekday', e=>{
                this.weekday=e;
            });
            this.$root.bus.$on('selectedClass', e=>{
                this.class=e;
            });
        },
        computed:{
            answer:{

                get(){

                    let [...temp]= this.classData;
                    for ( let data = temp.length-1 ; data>=0; data--) {

                        if (this.storeId.length) {
                            if (!this.storeId.includes(temp[data].storeId)) {
                                temp.splice(data, 1);
                                continue;
                            }
                        }
                         if(this.weekday.length){
                            if(!this.weekday.includes(temp[data].day)){
                                temp.splice(data,1);
                                continue;
                            }
                        }
                        if(this.teacher.length){
                            if(!this.teacher.includes(temp[data].teacher)){
                                temp.splice(data,1);
                                continue;
                            }
                        }
                        if(this.class.length){
                            if(!this.class.includes(temp[data].name)){
                                temp.splice(data,1);
                            }
                        }
                    }
                }
            }
        }
    }
</script>

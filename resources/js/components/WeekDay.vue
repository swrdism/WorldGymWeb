<template>
    <div>
        <input type="checkbox" id="all" value="all" v-model="all" @change="weekdayHandler">
        <label for="all">week</label>
        <span v-for="day in days">
            <input type="checkbox" :id="day" :value="day" v-model="weekday" @change="allHandler">
            <label :for="day">{{day}}</label>
        </span>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                all:null,
                weekday:[],
                days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]
            }
        },
        methods:{
            weekdayHandler(){
                if(this.$data.all){
                    this.$data.weekday=this.$data.days;
                }else{
                    this.$data.weekday=[];
                }
            },
            allHandler(){
                if(this.$data.weekday.length===7){
                    this.$data.all =true;
                }else{
                    if(this.$data.all){
                        this.$data.all=false;
                    }
                }

            }
        }
    }

</script>

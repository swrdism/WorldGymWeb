<template>
    <div>
        <input type="checkbox" id="all" value="all" v-model="all" @change="selectedWeekdayHandler">
        <label for="all">all</label>
        <span v-for="weekday in weekdays">
            <input type="checkbox" :id="weekday" :value="weekday" v-model="selectedWeekday" @change="allHandler">
            <label :for="weekday">{{weekday}}</label>
        </span>
    </div>
</template>

<script>
    export default {
        props:['shouldSubmit'],
        data(){
            return{
                all:null,
                selectedWeekday:[],
                weekdays:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]
            }
        },
        methods:{
            selectedWeekdayHandler(){
                if(this.$data.all){
                    this.$data.selectedWeekday=this.$data.weekdays;
                }else{
                    this.$data.selectedWeekday=[];
                }
            },
            allHandler(){
                if(this.$data.selectedWeekday.length===7){
                    this.$data.all =true;
                }else{
                    if(this.$data.all){
                        this.$data.all=false;
                    }
                }

            }
        },
        watch:{
            shouldSubmit:function () {
                if(this.shouldSubmit){
                    this.$root.bus.$emit('selectedWeekday',this.selectedWeekday);
                }else{
                    this.selectedWeekday=[];
                    this.all=false;
                }
            }
        }
    }

</script>

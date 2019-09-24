<template>

    <div v-if="storeData">
        <div v-for="city in storeData.list">
            <input
                type="checkbox"
                :id="city"
                :value="city"
                v-model="citySwitch"
            >
            <label :for="city">{{city}}</label>
            <br>
            <span v-for=" data  in storeData.map[city].list">
                <input
                    type="checkbox"
                    :id="data"
                    :value="data"
                    v-model="store"
                    @change="cityHandler">

                <label :for="data.name">{{data.name}}</label>
            </span>
        </div>
        <span>names: {{ store }}</span>
    </div>

</template>

<script>

    const axios = require('axios');

    export default {
        data () {
            return {
                rawData:null,
                store:[],
                citySwitch:[]
            }
        },
        mounted () {
            axios
                .get('http://localhost/api/getStoreDataList')
                .then(response => (this.rawData = response.data))
                .catch(function (error) {
                    console.log(error);
                });
        },
        computed:{
            storeData:{
                get(){
                    if (this.rawData !== null) {
                        let obj =
                            {
                                list: [],
                                map: {}
                            }
                        this.rawData.forEach(({name, city, storeId}) => {
                            if (!obj.list.includes(city)) {
                                obj.list.push(city);
                                obj.map[city] = {
                                    list: [],
                                }
                            }
                            obj.map[city].list.push({name,storeId});
                        })
                        return obj;
                    }else{
                        return null;
                    }
                }
            }
        },
        watch: {
            citySwitch: function (newVal, oldVal) {
                let addedCity = newVal.filter((e)=>{
                    return oldVal.indexOf(e) === -1
                })
                if(addedCity.length) {
                    this.storeData.map[addedCity].list.forEach((name) => {
                        if (!this.$data.store.includes(name)) {
                            this.$data.store.push(name);
                        }
                    })
                }
                let deletedCity= oldVal.filter((e)=>{
                    return newVal.indexOf(e) === -1;
                });
                if(deletedCity.length) {
                     this.storeData.map[deletedCity].list.forEach((name) => {
                         let index =this.$data.store.indexOf(name);
                         this.$data.store.splice( index,1 );
                     })

                 }
            }
        },
        methods:{
            cityHandler(){
                this.storeData.list.forEach((city)=>{
                    let item = this.storeData.map[city].list.filter((e)=>{
                        return this.$data.store.indexOf(e) !== -1;
                        });
                    if (this.storeData.map[city].list.length === item.length){
                         this.$data.citySwitch.push(city);
                    }else{
                        if (this.$data.citySwitch.includes(city)){
                            let index = this.$data.citySwitch.indexOf(city)
                            this.$data.citySwitch.splice( index,1 )
                        }

                    }
                })
            }
        }
    }


</script>


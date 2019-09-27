<template>

    <div v-if="storeData">
        <div v-for="city in storeData.list">
            <input
                type="checkbox"
                :id="city"
                :value="city"
                v-model="selectedcity"
            >
            <label :for="city">{{city}}</label>
            <br>
            <span v-for=" store  in storeData.map[city].list">
                <input
                    type="checkbox"
                    :id="store"
                    :value="store"
                    v-model="selectedStore"
                    @change="cityHandler">

                <label :for="store.name">{{store.name}}</label>
            </span>
        </div>
    </div>

</template>

<script>

    const axios = require('axios');

    export default {
        props:['shouldSubmit'],
        data () {
            return {
                rawData:null,
                selectedStore:[],
                selectedcity:[]
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
            selectedcity: function (newVal, oldVal) {
                let addedCity = newVal.filter((e)=>{
                    return oldVal.indexOf(e) === -1
                })
                if(addedCity.length) {
                    this.storeData.map[addedCity].list.forEach((name) => {
                        if (!this.$data.selectedStore.includes(name)) {
                            this.$data.selectedStore.push(name);
                        }
                    })
                }
                let deletedCity= oldVal.filter((e)=>{
                    return newVal.indexOf(e) === -1;
                });
                if(deletedCity.length) {
                     this.storeData.map[deletedCity].list.forEach((name) => {
                         let index =this.$data.selectedStore.indexOf(name);
                         this.$data.selectedStore.splice( index,1 );
                     })

                 }
            },

            shouldSubmit:function () {
                if(this.shouldSubmit){
                    this.$root.bus.$emit('selectedStore',this.selectedStore);
                }else{
                    this.selectedStore=[];
                    this.selectedcity=[];
                }
            }
        },
        methods:{
            cityHandler(){
                this.storeData.list.forEach((city)=>{
                    let item = this.storeData.map[city].list.filter((e)=>{
                        return this.$data.selectedStore.indexOf(e) !== -1;
                        });
                    if (this.storeData.map[city].list.length === item.length){
                         this.$data.selectedcity.push(city);
                    }else{
                        if (this.$data.selectedcity.includes(city)){
                            let index = this.$data.selectedcity.indexOf(city)
                            this.$data.selectedcity.splice( index,1 )
                        }

                    }
                })
            }
        }
    }


</script>


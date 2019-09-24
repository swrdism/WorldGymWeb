<template>

    <div v-if="classNameDataList">
        <div v-for="category in classNameDataList.list">
            <input
                type="checkbox"
                :id="category"
                :value="category"
                v-model="classSwitch"
            >
            <label :for="category">{{category}}</label>
            <br>
            <span v-for=" name  in classNameDataList.map[category].list">
                <input
                    type="checkbox"
                    :id="name"
                    :value="name"
                    v-model="className"
                    @change="categoryHandler"
                >
                <label :for="name">{{name}}</label>
            </span>
        </div>
        <span>names: {{ className }}</span>
    </div>

</template>

<script>

    const axios = require('axios');

    export default {
        data () {
            return {
                rawData:null,
                className:[],
                classSwitch:[]
            }
        },
        mounted () {
            axios
                .get('http://localhost/api/getClassNameDataList')
                .then(response => (this.rawData = response.data))
                .catch(function (error) {
                    console.log(error);
                });
        },
        computed:{
            classNameDataList:{
                get(){
                    if (this.rawData !== null) {
                        let obj =
                            {
                                list: [],
                                map: {}
                            }
                        this.rawData.forEach(({name, category}) => {
                            if (!obj.list.includes(category)) {
                                obj.list.push(category);
                                obj.map[category] = {
                                    list: []
                                }
                            }
                            obj.map[category].list.push(name);
                        })
                        return obj;
                    }else{
                        return null;
                    }
                }
            }
        },
        watch: {
            classSwitch: function (newVal, oldVal) {
                let addedCategory = newVal.filter((e)=>{
                    return oldVal.indexOf(e) === -1
                })
                if(addedCategory.length) {
                    this.classNameDataList.map[addedCategory].list.forEach((name) => {
                        if (!this.$data.className.includes(name)) {
                            this.$data.className.push(name);
                        }
                    })
                }
                let deletedCategory= oldVal.filter((e)=>{
                    return newVal.indexOf(e) === -1;
                });
                if(deletedCategory.length) {
                     this.classNameDataList.map[deletedCategory].list.forEach((name) => {
                         let index =this.$data.className.indexOf(name);
                         this.$data.className.splice( index,1 );
                     })

                 }
            }
        },
        methods:{
            categoryHandler(){
                this.classNameDataList.list.forEach((category)=>{
                    let item = this.classNameDataList.map[category].list.filter((e)=>{
                        return this.$data.className.indexOf(e) !== -1;
                        });
                    if (this.classNameDataList.map[category].list.length === item.length){
                        this.$data.classSwitch.push(category);
                    }else{
                        if (this.$data.classSwitch.includes(category)){
                            let index = this.$data.classSwitch.indexOf(category)
                            this.$data.classSwitch.splice( index,1 )
                        }
                    }
                })
            }
        }
    }


</script>


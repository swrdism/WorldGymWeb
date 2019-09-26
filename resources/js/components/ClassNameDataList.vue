<template>

    <div v-if="classDataList">
        <div v-for="category in classDataList.list">
            <input
                type="checkbox"
                :id="category"
                :value="category"
                v-model="selectedCategory"
            >
            <label :for="category">{{category}}</label>
            <br>
            <span v-for=" name  in classDataList.map[category].list">
                <input
                    type="checkbox"
                    :id="name"
                    :value="name"
                    v-model="selectedClass"
                    @change="categoryHandler"
                >
                <label :for="name">{{name}}</label>
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
                selectedClass:[],
                selectedCategory:[]
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
            classDataList:{
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
            selectedCategory: function (newVal, oldVal) {
                let addedCategory = newVal.filter((e)=>{
                    return oldVal.indexOf(e) === -1
                })
                if(addedCategory.length) {
                    this.classDataList.map[addedCategory].list.forEach((name) => {
                        if (!this.$data.selectedClass.includes(name)) {
                            this.$data.selectedClass.push(name);
                        }
                    })
                }
                let deletedCategory= oldVal.filter((e)=>{
                    return newVal.indexOf(e) === -1;
                });
                if(deletedCategory.length) {
                     this.classDataList.map[deletedCategory].list.forEach((name) => {
                         let index =this.$data.selectedClass.indexOf(name);
                         this.$data.selectedClass.splice( index,1 );
                     })

                 }
            },
            shouldSubmit:function () {
                if(this.shouldSubmit){
                    this.$root.bus.$emit('selectedClass',this.selectedClass);
                }else{
                    this.selectedClass=[];
                    this.selectedCategory=[];
                }
            }
        },
        methods:{
            categoryHandler(){
                this.classDataList.list.forEach((category)=>{
                    let item = this.classDataList.map[category].list.filter((e)=>{
                        return this.$data.selectedClass.indexOf(e) !== -1;
                        });
                    if (this.classDataList.map[category].list.length === item.length){
                        this.$data.selectedCategory.push(category);
                    }else{
                        if (this.$data.selectedCategory.includes(category)){
                            let index = this.$data.selectedCategory.indexOf(category)
                            this.$data.selectedCategory.splice( index,1 )
                        }
                    }
                })
            }
        }
    }


</script>


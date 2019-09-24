<template>

    <div v-if="isUpdating">
        <p>
            Updating Data Now
            {{isUpdated}}
        </p>
    </div>

</template>

<script>

    const axios = require('axios');

    let isUpdating;
    let isUpdated;

    axios.get('http://localhost/api/getIsUpdated').then(function (response) {
        isUpdated = response.data;
        isUpdating = false;
    }).catch(function (error) {
        console.log(error);
    });

    export default {
        data () {
            return {
                isUpdated:isUpdated
            }
        },
    }
</script>

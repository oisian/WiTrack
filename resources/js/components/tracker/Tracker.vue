
<template>
    <div class="panel panel-default">
        <div class="panel-heading text-center">Past movements
        </div>
        <div class="panel-body">

            <table class="table table-striped">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Reported From</th>
                    <th scope="col">Mac Address</th>
                    <th scope="col">Wifi Type</th>
                    <th scope="col">Frequency</th>
                    <th scope="col">Signal Strength</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="p in deviceData">
                    <td>{{ p['reportedFrom'] }}</td>
                    <td>{{ p['mac'] }}</td>
                    <td>{{ p['type'] }}</td>
                    <td>{{ p['frequency'] }}</td>
                    <td>{{ p['signalStrength'] }}Dbm</td>

                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>



<script>
    export default {
        data() {
            return {
                deviceData: this.deviceData
            }
        },
        created() {
            this.getDeviceData();
            setInterval(function () {
                this.getDeviceData();
            }.bind(this), 15000);
        },
        methods:{
            getDeviceData(){
                window.axios.get('api/v1/track/getdevices')
                    .then((response) => {
                        this.deviceData = response.data;
                    })
                    .catch((error) => {
                            if (error.response) {
                                console.log(error.response);
                            } else {
                                console.log('Error', error.message);
                            }
                            console.log(error.config);
                        }
                    );
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<template>
    <div>
        <div id="reference" class="section">
            <div class="columns is-centered">
                <div class="column is-6">

                    <div class="box">
                        <h1 class="subtitle has-text-weight-bold">
                            ENROLLMENT REFERENCE NUMBER
                        </h1>
                        <h1 class="title p-4">
                             {{propRef}}
                        </h1>

                        <div>
                            Please save this reference number (take screenshot) for your records, it will be used during the enrollment process.
                        </div>

                        <div class="buttons mt-2">
                            <b-button type="is-info" label="HOME"
                                tag="a" href="/"></b-button>

                            <!-- <b-button type="is-info" label="SCREENSHOT" @click="screenShot"></b-button> -->
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>


export default{
    

    props: {
        propRef: {
            type: String,
            default: ''
        }
    },
    data(){
        return {
        }
    },

    methods: {
        takeScreenshot(){
            html2canvas(document.querySelector("#reference")).then(canvas => {
                document.body.appendChild(canvas)
            });
        },

        screenShot(){
            const screenshotTarget = document.getElementById('reference');

            html2canvas(screenshotTarget).then((canvas) => {
                const base64image = canvas.toDataURL("image/png");
                window.location.href = base64image;
            });
        },

        async capture(){
            const canvas = document.createElement("canvas");
            const context = canvas.getContext("2d");
            const video = document.createElement("video");

            try {
                const captureStream = await navigator.mediaDevices.getDisplayMedia();
                video.srcObject = captureStream;
                context.drawImage(video, 0, 0, window.width, window.height);
                const frame = canvas.toDataURL("image/png");
                captureStream.getTracks().forEach(track => track.stop());
                window.location.href = frame;
            } catch (err) {
                console.error("Error: " + err);
            }
        }
    },

    mounted(){

    }
}
</script>
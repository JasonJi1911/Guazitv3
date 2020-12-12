<style>
    #overlay {
        background: #000;
        filter: alpha(opacity=50); /* IE的透明度 */
        opacity: 0.5; /* 透明度 */
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        z-index: 100; /* 此处的图层要大于页面 */
        padding: 300px 300px 300px 800px;
        color: #999;
        font-size: 24px;
        font-weight: bold;
        display: none;
    }
</style>
<div id="overlay">上传中，请稍等.....</div>

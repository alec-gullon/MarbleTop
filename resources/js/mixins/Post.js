export default {
    methods: {
        post: function(path, data, callback) {
            if (document.global.xhrActive) {
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open('post', path, true);
            xhr.setRequestHeader('Accept', 'application/json');

            xhr.responseType = 'json';
            xhr.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    callback(xhr.response);
                }
            };

            document.global.xhrActive = true;
            xhr.send(data);
        }
    }
}

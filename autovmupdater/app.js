const { createApp } = Vue

  createApp({
    data() {
      return {
        iframeAddress : '/autovmupdatepage.php',
        ActonResponse : null,
        ChoseVersion: null,
      }
    },

    methods: {
        funcDelete() {
          axios.post('./autovmupdatefunc.php', {funcmethod: 'delete'})
          .then(response => {
            // Handle the response from the server
            this.ActonResponse = response.data
          })
          .catch(error => {
            // Handle errors
            this.ActonResponse = error;
          });
        }, 

        funcInstall() {
          axios.post('./autovmupdatefunc.php', {funcmethod: 'install'})
          .then(response => {
            // Handle the response from the server
            this.ActonResponse = response.data
          })
          .catch(error => {
            // Handle errors
            this.ActonResponse = error;
          });
        },

        funcUpdate() {
          axios.post('./autovmupdatefunc.php', {funcmethod: 'update'})
          .then(response => {
            // Handle the response from the server
            this.ActonResponse = response.data
          })
          .catch(error => {
            // Handle errors
            this.ActonResponse = error;
          });
        },
        
        funcFix() {
          axios.post('./autovmupdatefunc.php', {funcmethod: 'fix'})
          .then(response => {
            // Handle the response from the server
            this.ActonResponse = response.data
          })
          .catch(error => {
            // Handle errors
            this.ActonResponse = error;
          });
        }
    },

  }).mount('#app')
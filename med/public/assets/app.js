const baseurl = document.querySelector('meta[name=baseurl]').content


new Vue({
  el: '#root',

  data: {
    data: [],
    isNew: true,
    modalTitle: 'Add Record',
    modalVisible: false,

    // 
    id: 0,
    name: '',
    unit: '',
    low: '',
    high: '',

    // 
    error: '',
  },

  created: function() {
    this.loadData()
  },

  methods: {

    loadData: function() {
      fetch(baseurl + '/api/v2/fetchRecords')
        .then(response => {
          if (response.ok) {
            return response.json()
          }

          throw "Something went wrong trying to get the response"
        }).then(response => {
        if (response.status === true) {
          this.data = response.data
        } else {
          throw response.message
        }
      }).catch(err => {
        swal('Failed!', err, 'error')
      })
    },

    saveChanges: function() {
      if (this.isNew === true) {
        this.modalTitle = 'Add Record'
        this.createNew()
      } else {
        this.modalTitle = 'Edit Record'
        this.updateElement()
      }
    },

    hideForm: function() {
      this.modalVisible = false
      this.isNew = false
      this.id = 0
      this.name = ''
      this.unit = ''
      this.low = ''
      this.high = ''
    },

    setupEditForm: function(id) {
      fetch(baseurl + '/api/v2/fetchRecord/' + id)
        .then(response => {
          if (response.ok) {
            return response.json()
          }

          throw "Something went wrong trying to get the response"
        }).then(response => {
        if (response.status === true) {
          this.id = response.data.id
          this.name = response.data.name
          this.unit = response.data.unit
          this.low = response.data.low
          this.high = response.data.high
          this.isNew = false
          this.modalVisible = true
        } else {
          throw 'Something went wrong and id ' + id + ' wasn\'t found'
        }
      }).catch(err => {
        swal('Failed!', err, 'error')
      })
    },

    createNew: function() {
      let data = {
        name: this.name,
        unit: this.unit,
        high: this.high,
        low: this.low,
      }

      fetch(baseurl + '/api/v2/AddRecord', {
        method: 'POST',
        body: JSON.stringify(data)
      }).then(response => {
        if (response.ok) return response.json()
        throw "Something went wrong trying to create record"
      }).then(response => {
        if (response.status === true) {
          this.hideForm()
          this.loadData()
          swal('Success!', 'record was created!', 'success')
        } else {
          this.error = response.message
        }
      }).catch(err => {
        swal('Failed!', err, 'error')
      })
    },


    updateElement: function() {
      let data = {
        id: this.id,
        name: this.name,
        unit: this.unit,
        high: this.high,
        low: this.low,
      }

      fetch(baseurl + '/api/v2/UpdateRecord', {
        method: 'POST',
        body: JSON.stringify(data)
      }).then(response => {
        if (response.ok) return response.json()
        throw "Something went wrong trying to update record"
      }).then(response => {
        if (response.status === true) {
          this.hideForm()
          this.loadData()
          swal('Success!', 'record was updated!', 'success')
        } else {
          this.error = response.message
        }
      }).catch(err => {
        swal('Failed!', err, 'error')
      })
    },

    deleteElement: function(id) {

      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          let data = {
            id: id
          }

          fetch(baseurl + '/api/v2/DeleteRecord', {
            method: 'POST',
            body: JSON.stringify(data)
          }).then(response => {
            if (response.ok) return response.json()
            throw "Something went wrong trying to delete record"
          }).then(response => {
            if (response.status === true) {
              this.loadData()
              swal('Success!', 'record was deleted!', 'success')
            } else {
              alert(response.message)
            }
          }).catch(err => {
            swal('Failed!', err, 'error')
          })

        }
      })
    }


  }


})
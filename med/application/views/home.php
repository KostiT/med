<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="baseurl" content="<?= base_url() ?>">

    <title>Medical App</title>

    <link href="https://getbootstrap.com/docs/3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.2/sweetalert2.min.css">
  </head>

  <body>
    <div class="container" id="root">

      <div class="jumbotron">
        <h1>Medical App</h1>
      </div>

      <div class="row">
        <div class="col-md-12 text-right">
          <a href="#" class="btn btn-success" @click.prevent="modalVisible = true; isNew = true">Add New</a>
        </div>

        <div class="col-md-12">
          <table class="table">
            <thead>
              <th>Subject of Measurement</th>
              <th>Unit</th>
              <th>Low</th>
              <th>High</th>
              <th>Actions</th>
            </thead>

            <tbody>
              <tr v-for="row in data">
                <td>{{ row.name }}</td>
                <td>{{ row.unit }}</td>
                <td>{{ row.low }}</td>
                <td>{{ row.high }}</td>
                <td>
                  <a href="#" class="btn btn-warning" @click.prevent="setupEditForm(row.id)">Edit</a>
                  <a href="#" class="btn btn-danger"  @click.prevent="deleteElement(row.id)">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>


      <div class="modal fade" tabindex="-1" role="dialog" :class="{ in: modalVisible }" :style="{ display: modalVisible === true ? 'block' : 'none' }">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" @click.prevent="hideForm()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">{{ modalTitle }}</h4>
            </div>
            <div class="modal-body">
              <div class="alert alert-danger" v-if="error != ''">
                {{ error }}
              </div>
              <form>
                <input type="hidden" name="id" v-model="id">
                <div class="form-group">
                  <label for="name">Subject of Measurement</label>
                  <input type="text" v-model="name" class="form-control" id="name" placeholder="Subject of Measurement">
                </div>
                <div class="form-group">
                  <label for="unit">Unit</label>
                  <input type="text" v-model="unit" class="form-control" id="unit" placeholder="Unit">
                </div>
                <div class="form-group">
                  <label for="low">Low</label>
                  <input type="text" v-model="low" class="form-control" id="low" placeholder="Low">
                </div>
                <div class="form-group">
                  <label for="high">High</label>
                  <input type="text" v-model="high" class="form-control" id="high" placeholder="High">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" @click.prevent="hideForm()">Close</button>
              <button type="button" class="btn btn-primary" @click.prevent="saveChanges()">Save changes</button>
            </div>
          </div>
        </div>
      </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.2/sweetalert2.min.js"></script>
    <script src="public/assets/app.js"></script>
  </body>
</html>

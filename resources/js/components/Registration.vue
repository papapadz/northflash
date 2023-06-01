<template>
    <div>
      <div v-if="page==1" class="card mb-2">
          <div class="card-header">Personal Information</div>
          <div class="card-body">
              <div class="form-group">
        <label>Last Name <span class="text-danger">*</span></label>
        <input type="text" v-model="employee.lastName" class="form-control" required placeholder="ex. Dela Cruz">
      </div>
      <div class="form-group">
        <label>First Name <span class="text-danger">*</span></label>
        <input type="text" v-model="employee.firstName" class="form-control" required placeholder="ex. Juan">
      </div>
      <div class="form-group">
        <label>Middle Name</label>
        <input type="text" v-model="employee.middleName" class="form-control" placeholder="ex. Aguinaldo">
      </div>
      <div class="form-group">
        <label>Date of Birth <span class="text-danger">*</span></label>
        <input type="date" v-model="employee.dateOfBirth" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Sex <span class="text-danger">*</span></label>
        <v-select label="Sex" :options="arrGender" v-model="employee.sex"></v-select>
      </div>
      <div class="form-group">
        <label>Civil Status <span class="text-danger">*</span></label>
        <v-select label="Civil Status" :options="arrCivilStatus" v-model="employee.civilStatus"></v-select>
      </div>
      <div class="form-group">
        <label>Citizenship <span class="text-danger">*</span></label>
        <input type="text" v-model="employee.citizenship" class="form-control" placeholder="ex. Filipino" required>
      </div>
      <div class="form-group">
        <label>Address <span class="text-danger">*</span></label>
        <textarea v-model="employee.address" class="form-control" required placeholder="ex. Brgy. 5, Poblacion, Calamba, Laguna"></textarea>
      </div>
      <div class="form-group">
        <label>Height (in meters) <span class="text-danger">*</span></label>
        <input type="number" v-model="employee.height" class="form-control" required step="0.01" min="1" placeholder="ex 1.2">
      </div>
      <div class="form-group">
        <label>Weight (in kilograms) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" min="30" v-model="employee.weight" class="form-control" placeholder="ex. 50" required>
      </div>
      <div class="form-group">
        <label>Blood Type <span class="text-danger">*</span></label>
        <v-select label="Blood Type" :options="arrBloodType" v-model="employee.bloodType"></v-select>
      </div>
          </div>
      </div>
      <div v-else-if="page==2" class="card mb-2">
          <div class="card-header">Contact Information</div>
          <div class="card-body">
              <div class="form-group">
                <label>Email Address</label>
                <input type="email" v-model="employee.emailAddress" class="form-control" placeholder="ex. email@email.com">
              </div>
              <div class="form-group">
                <label>Contact Number</label>
                <input type="tel" v-model="employee.contactNumber" class="form-control" placeholder="ex. 091234567891">
              </div>
          </div>
      </div>
      <div v-else-if="page==3" class="card mb-2">
          <div class="card-header">Legal Documents/ID's</div>
          <div class="card-body">
              <div class="form-group">
                <label>TIN</label>
                <input type="text" minlength="9" v-model="employee.tin" class="form-control">
              </div>
              <div class="form-group">
                <label>Pag-IBIG ID No.</label>
                <input type="text" minlength="12" v-model="employee.pagibigIdNo" class="form-control">
              </div>
              <div class="form-group">
                <label>PhilHealth No.</label>
                <input type="text" minlength="12" v-model="employee.philHealthNo" class="form-control">
              </div>
              <div class="form-group">
                <label>SSS No.</label>
                <input type="text" minlength="10" v-model="employee.sssNo" class="form-control">
              </div>
              <div class="form-group">
                <label>Eligibility</label>
                <input type="text" v-model="employee.eligibility" class="form-control" placeholder="ex. Electrical Engineer">
              </div>
          </div>
      </div>
      <div v-else-if="page==4" class="card mb-2">
          <div class="card-header">Family Background</div>
          <div class="card-body">
            <div v-if="employee.civilStatus=='Married'">
              <div class="form-group">
                <label>Spouse's Maiden Name (Last, First, Middle)</label>
                <input type="text" v-model="employee.spouseName" class="form-control" placeholder="ex. Alba, Maria Clara, delos Santos">
              </div>
              <div class="form-group">
                <label>Spouse's Occupation</label>
                <input type="text" v-model="employee.spouseOccupation" class="form-control" placeholder="ex. Housekeeper">
              </div>
              <div class="form-group">
                <label>Spouse's Phone No.</label>
                <input type="tel" v-model="employee.spousePhone" class="form-control" placeholder="ex. 091234567891">
              </div>
            </div>
            <div class="form-group">
              <label>Father's Name (Last, First, Middle)</label>
              <input type="text" v-model="employee.fatherName" class="form-control" required placeholder="ex. Rizal, Jose, Protacio">
            </div>
            <div class="form-group">
              <label>Mother's Maiden Name (Last, First, Middle)</label>
              <input type="text" v-model="employee.motherName" class="form-control" required placeholder="ex. Bracken, Marie Josephine, Leopoldine">
            </div>
          </div>
      </div>
      <div v-else-if="page==5" class="card mb-2">
          <div type="button" class="card-header">Educational Background <button class="btn btn-sm btn-primary float-right" @click.prevent="addEducation">Add Education</button></div>
          <div class="card-body">
              <div v-for="(educ, index) in education" :key="index">
                <div class="form-group">
                  <label>Educational level</label>
                  <select v-model="educ.level" class="form-control">
                    <option value="" disabled>Educational level</option>
                    <option value="Elementary">Elementary</option>
                    <option value="HighSchool">High School</option>
                    <option value="College">College</option>
                    <option value="Masters">Masters</option>
                  </select>
                </div>
                <div class="form-group">
                    <label>School</label>
                    <input type="text" v-model="educ.school" class="form-control" placeholder="ex. Central Elementary School">
                </div>
                <div class="form-group">
                    <label>Year Graduated</label>
                    <input type="number" v-model="educ.year" class="form-control" placeholder="ex. 2001"  maxlength="4">
                </div>
            </div>
          </div>
      </div>
      <div v-else-if="page==6" class="card mb-2">
          <div class="card-header">Nortflash Employment</div>
          <div class="card-body">
            <div class="form-group">
              <label>Current Position</label>
              <input type="text" v-model="employee.currentPosition" class="form-control" required placeholder="ex. Groundman">
            </div>
            <div class="form-group">
              <label>Current Pay</label>
              <input type="number" min="100" v-model="employee.currentSalary" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Date Employed</label>
              <input type="date" v-model="employee.currentDateEmployed" class="form-control" required>
            </div>
          </div>
      </div>
      <div v-else-if="page==7" class="card mb-2">
          <div class="card-header">Previous Work Experience <button class="btn btn-sm btn-primary float-right" @click.prevent="addWorkExperience">Add Work Experience</button></div>
          <div class="card-body">
              <div v-for="(exp, index) in workExperience" :key="index">
                <div class="form-group">
                  <label>Company Name</label>
                  <input type="text" v-model="exp.companyName" class="form-control" placeholder="ex. ABC Company">
                </div>
                <div class="form-group">
                  <label>Position</label>
                  <input type="text" v-model="exp.position" class="form-control" placeholder="ex. Driver">
                </div>
                <div class="form-group">
                  <label>Pay</label>
                  <input type="number" min="100" v-model="exp.salary" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Year Started</label>
                  <v-select :options="getYears" label="Year Started" v-model="exp.year"></v-select>
                </div>
            </div>
          </div>
      </div>
      <div v-else-if="page==8" class="card mb-2">
          <div class="card-header">Picture</div>
          <div class="card-body">
              <div class="form-group">
                <input type="file" class="form-control-file" id="avatar" @change="handleFileUpload" accept="image/*" required>
                <img v-if="avatar" :src="avatar" class="img-fluid mt-2" style="height: 150px; width: 150px" alt="Avatar preview">
              </div>
          </div>
          <button v-if="!submitted" class="btn btn-primary w-100" type="submit">Submit</button>
            <button v-else class="btn btn-primary w-100" type="button">
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </button>
      </div>
      <small class="text-danger"><i>* Required Fields</i></small>
      <hr />
      <button v-if="page>1" class="btn btn-warning float-left" @click="page--">Back</button>
      <button v-if="page<8" class="btn btn-primary float-right" @click="next">Next</button>
    </div>
  </template>
  <script>
  export default {
      props: ['csrf'],
      data() {
          return {
              page: 1,
              arrGender: ['Male','Female'],
              arrCivilStatus: ['Single','Married','Widowed','Divorced'],
              arrBloodType: ['A','B','AB','O'],
              arrEducationLevel: ['Elementary','High School','College','Masters'],
              submitted: false,
              registered: false,
              employee: {
                  lastName: "",
                  firstName: "",
                  middleName: "",
                  dateOfBirth: "",
                  sex: "Male",
                  civilStatus: "Single",
                  citizenship: "Filipino",
                  address: "",
                  height: "",
                  weight: "",
                  bloodType: "A",
                  emailAddress: "",
                  contactNumber: "",
                  tin: "",
                  pagibigIdNo: "",
                  philHealthNo: "",
                  sssNo: "",
                  spouseName: "",
                  spouseOccupation: "",
                  spousePhone: "",
                  fatherName: "",
                  motherName: "",
                  eligibility: "",
                  currentPosition: "",
                  currentDateEmployed: "",
                  currentSalary: 0,
                  picture: null,
                  _token: this.csrf
              },
              education: [],
              workExperience: [],
              avatar: null,
              emp_id: '',
              message: ''
          }
      }, 
      computed: {
        getYears() {
          const now = new Date()
          const arrYears = []
          let y = now.getFullYear()
          do {
            arrYears.push(y)
            y--
          } while (y >=1990)

          return arrYears
        }
      },
      methods: {
          addWorkExperience() {
              this.workExperience.push({
                  companyName: "",
                  position: "",
                  year: "",
                  salary: 0
              });
          },
          addEducation() {
              this.education.push({
                  level: "",
                  school: "",
                  year: "",
              });
          },
          handleSubmit() {
              this.submitted = true
              const self = this
              const formData = new FormData();
              for (let key in this.employee) {
                  formData.append(key, this.employee[key]);
              }
              formData.append('education',JSON.stringify(this.education))
              formData.append('workExperience',JSON.stringify(this.workExperience))
              
              axios.post('employee/v2/register', formData, {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
              }).then(response => {
                if(response.data.code=='OK') {
                    self.emp_id = response.data.employee_id
                    self.registered = true
                    if(response.data.status=='NEW')
                      self.message = "Thank you for registering!"
                    else
                      self.message = "Thank you for updating your information!"
                  }
              }).catch(error => {
                  alert("Please refresh the page and try again!")
              });
          },
          handleFileUpload(e) {
            // update the avatar data property with the selected file
            const file = e.target.files[0];
            this.employee.picture = file
            this.avatar = URL.createObjectURL(file);
          },
          refresh() {
            location.reload();
          },
          next() {
            let hasError = false
            switch(this.page) {
              case 1:
                if(this.employee.lastName=='' ||
                  this.employee.firstName=='' ||
                  this.employee.dateOfBirth=='' ||
                  this.employee.citizenship=='' ||
                  this.employee.address=='' ||
                  Number(this.employee.height) <= 0 ||
                  Number(this.employee.weight) <= 0
                ) 
                hasError = true
              break
            }

            if(hasError)
              alert('Please fill up all required fields!')
            else
              this.page++
          }
      },
  };
  </script>
  
  <style>
  .container {
    max-width: 600px;
    margin: auto;
  }
  </style>
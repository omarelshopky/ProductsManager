<style>
  .page-header {
      text-align: left;
  }

  .input-groupp {
    text-align: start;
  }

  .feedback {
    text-align: center;
    color: #dc3545;
    display: block;
  }
</style>

<div id="app" v-cloak>

  <div class="d-flex flex-row justify-content-between col-md-12">

    <h1 class="page-header"> <?php echo $title; ?> </h1>

    <div class="page-btn-container">

      <a href="" @click.prevent="saveProduct" class="btn btn-info m-3"> Save </a>

      <a href="/" class="btn btn-danger m-3"> Cancel </a>

    </div>

  </div>

  <hr class="m-1">

  <form class="col-lg-5 col-md-10 mt-5 needs-validation" id="product_form" novalidate>

    <custom-input 
      v-for="(attribute, i) in product"
      :key="i"
      :name="attribute.name"
      :label="attribute.label"
      :type="attribute.type"
      :value="attribute.value"
      :feedback="attribute.feedback"
      @update-value="updateValue"
    ></custom-input>

    <div class="form-group input-groupp row">

      <label for="productType" class="col-sm-5 col-form-label-lg p-1"> Type Switcher </label>

      <div class="col-sm-7">

        <select id="productType" class="form-control" @change="changeType()">
          <option selected disabled> Type Switcher </option>
          <option v-for="type in availableTypes" :value="type" :id="type">{{ type }}</option>
        </select>

        <div class="feedback">
          {{ productTypeFeedback }}
        </div>
      </div>
      
    </div>
    
    <div v-if="productType">
      <custom-input 
        v-for="(attribute, i) in details[productType].attributes"
        :key="i"
        :name="attribute.name"
        :label="attribute.label"
        :type="attribute.type"
        :value="attribute.value"
        :feedback="attribute.feedback"
        @update-value="updateValue"
      ></custom-input>
      <p>{{ details[productType].description }}</p>
    </div>

  </form>

</div>

<script src="https://unpkg.com/vue@3"></script>
<script>

  let app = Vue.createApp({
      data() {
          return {
            product: {
              sku: {
                name: "sku",
                label: "SKU",
                type: "text",
                value: "",
                feedback: ""
              },
              name: {
                name: "name",
                label: "Name",
                type: "text",
                value: "",
                feedback: ""
              },
              price: {
                name: "price",
                label: "Price",
                type: "number",
                value: "",
                feedback: ""
              }
            },
            details: {
              Book: {
                attributes: {
                  weight: {
                    name: "weight",
                    label: "Weight (KG)",
                    type: "number",
                    value: "",
                    feedback: ""
                  }
                },
                description: "Please, provide weight in KG"
              },
              DVD: {
                attributes: {
                    size: {
                    name: "size",
                    label: "Size (MB)",
                    type: "number",
                    value: "",
                    feedback: ""
                  }
                },
                description: "Please, provide size in MB"
              },
              Furniture: {
                attributes: {
                  height: {
                    name: "height",
                    label: "Height (CM)",
                    type: "number",
                    value: "",
                    feedback: ""
                  },
                  width: {
                    name: "width",
                    label: "Width (CM)",
                    type: "number",
                    value: "",
                    feedback: ""
                  },
                  length: {
                    name: "length",
                    label: "Length (CM)",
                    type: "number",
                    value: "",
                    feedback: ""
                  }
                },
                description: "Please, provide dimensions in HxWxL format"
              }
            },
            availableTypes: <?php echo json_encode($GLOBALS["PRODUCT_TYPES"]); ?>,
            productType: "",
            productTypeFeedback: ""
        }
      },
      methods: {
        changeType() {
          let typeSwitcher = document.querySelector("#productType")
          this.productType = typeSwitcher.options[typeSwitcher.selectedIndex].value

          // Remove invalid type class
          typeSwitcher.classList.remove("is-invalid")
          this.productTypeFeedback = ""
        },
        updateValue(inputId, value) {
          product = (this.product[inputId])? this.product[inputId] : this.details[this.productType].attributes[inputId]
          product.value = value
          let input = document.querySelector("#" + inputId)
          
          if (product.type === "number" && value === ""){ //Validate Numeric values
            input.classList.add("is-invalid")
            product.feedback = `Please, provide numeric ${inputId}.`

          } else { // Remove invalid type class
            input.classList.remove("is-invalid")
            product.feedback = ""
          }
        },
        validate(data) {
          for (const key in data) {
            
            // Check Required Inputs
            if (data[key] === ""){

              if (key == "type") { // Check that user choose a type
                let typeSwitcher = document.querySelector("#productType")
                typeSwitcher.classList.add('is-invalid')
                this.productTypeFeedback = "Please choose a valid type."

              }else {
                product = (this.product[key])? this.product[key] : this.details[this.productType].attributes[key]
                document.querySelector("#" + key).classList.add("is-invalid")

                if (product.type === "number") {
                  product.feedback = `Please, provide numeric ${key}.`
                }else{
                  product.feedback = "Please, submit required data"
                }
              }
            }
          }

          return (document.querySelectorAll(".is-invalid").length == 0)
        },
        saveProduct() {
          let data = { 
            sku: this.product.sku.value,
            name: this.product.name.value,
            price: this.product.price.value,
            type: this.productType
          }

          if (data.type != ""){
            for (const key in this.details[this.productType].attributes) {
              data[key] = this.details[this.productType].attributes[key].value
            }
          }

          if (this.validate(data)){
            fetch(window.location.origin + "/add-product/", {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify(data)
            })
              .then(response => response.json())
              .then((data) => {
                if (data.msg === "SKU Must be Unique for each product") {
                  document.querySelector("#sku").classList.add("is-invalid")
                  this.product.sku.feedback = data.msg
                  
                } else {// Redirect to the home page
                  window.location.href = window.location.origin 
                }
              });
          }
        }
      }
  })

  app.component("custom-input", {
    props: ["name", "label", "type", "value", "feedback"],
    template: `
      <div class="form-group input-groupp row">
        <label :for="name" class="col-sm-3 col-form-label-lg p-1">{{ label }}</label>
        <div class="col-sm-9">
          <input :type="type" v-model="inputValue" class="form-control" :id="name" :placeholder="label" required>

          <div class="feedback">
            {{ feedback }}
          </div>
        </div>
      </div>
      `,
    computed: {
      inputValue: {
        get() {
          return this.value
        },
        set(value) {
          this.$emit("update-value", this.name, value)
        }
      }
    }
  })

  app.mount('#app')
</script> 


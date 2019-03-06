import "antd/dist/antd.css";
import { Modal, Button, Form, Select, Table, Divider, Tag } from "antd";
const FormItem = Form.Item;
const { Option } = Select;
class Equivalencias extends React.Component {
  constructor(props) {
    super(props);
    this.showModal = this.showModal.bind(this);
    this.handleOk = this.handleOk.bind(this);
    this.handleCancel = this.handleCancel.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.getSubjectsOrigin = this.getSubjectsOrigin.bind(this);
    this.getSubjectsDestination = this.getSubjectsDestination.bind(this);
    this.state = {
      visible: false,
      subjectOrigin: []
    };
  }

  componentDidMount() {
    //llamar a la funcion que trae los datos de la tabla
    this.getSubjectsOrigin();
    this.getSubjectsDestination();
  }

  getSubjectsOrigin() {
    let { voucher_id } = this.props;
    let _this = this;
    fetch("/admin/voucher/getSubjectsOrigin/" + voucher_id, {
      method: "get",
      credentials: "same-origin"
    })
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        console.log("origen: " + data);
        _this.setState({ subjectOrigin: data });
      })
      .catch(function(e) {
        console.log(e);
      });
  }

  getSubjectsDestination() {
    let { voucher_id } = this.props;
    let _this = this;
    fetch("/admin/voucher/getSubjectsDestination/" + voucher_id, {
      method: "get",
      credentials: "same-origin"
    })
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        console.log("destino: " + data);
        _this.setState({ subjectDestination: data });
      })
      .catch(function(e) {
        console.log(e);
      });
  }

  showModal() {
    this.setState({
      visible: true
    });
  }

  handleOk(e) {
    console.log(e);
    this.setState({
      visible: false
    });
  }

  handleCancel(e) {
    console.log(e);
    this.setState({
      visible: false
    });
  }

  handleSubmit(e) {
    const { form } = this.props;
    if (e) {
      e.preventDefault();
    }
    form.validateFieldsAndScroll((err, values) => {
      if (!err) {
        console.log(values);
      }
    });
  }

  render() {
    const { form } = this.props;
    const { getFieldDecorator } = form;
    const { subjectOrigin } = this.state;
    const { subjectDestination } = this.state;
    const optionsSubjectOrigin = subjectOrigin.map(d => (
      <Option key={d.subjectId} value={d.subjectId}>
        {d.subjectName}
      </Option>
    ));

    const optionsSubjectDestination = subjectDestination.map(d => (
      <Option key={d.subjectId} value={d.subjectId}>
        {d.subjectName}
      </Option>
    ));
    return (
      <div>
        <Button type="primary" onClick={this.showModal}>
          Open Modal
        </Button>
        <Modal
          title="Por favor, seleccione las asignaturas equivalentes"
          visible={this.state.visible}
          onOk={this.handleSubmit}
          onCancel={this.handleCancel}
        >
          <Form onSubmit={this.handleSubmit}>
            <FormItem label="Codigo de materias">
              {getFieldDecorator("equivalentsSubjects", {
                rules: [
                  {
                    required: true,
                    message: "Este campo es requerido"
                  }
                ]
              })(
                <Select
                  notFoundContent="No se encontraron resultados"
                  showSearch
                  filterOption={(input, option) =>
                    option.props.children
                      .toLowerCase()
                      .indexOf(input.toLowerCase()) >= 0
                  }
                  style={{ width: "100%" }}
                  mode="multiple"
                  placeholder="Seleccione"
                >
                  {optionsSubjectOrigin}
                </Select>
              )}
            </FormItem>
            <FormItem label="Asignatura equivalente">
              {getFieldDecorator("approvedSubject", {
                initialValue: "",
                rules: [
                  {
                    required: true,
                    message: "Este campo es requerido"
                  }
                ]
              })(
                <Select
                  notFoundContent="No se encontraron resultados"
                  showSearch
                  filterOption={(input, option) =>
                    option.props.children
                      .toLowerCase()
                      .indexOf(input.toLowerCase()) >= 0
                  }
                  style={{ width: "100%" }}
                  placeholder="Seleccione"
                >
                  {optionsSubjectDestination}
                </Select>
              )}
            </FormItem>
          </Form>
        </Modal>
      </div>
    );
  }
}
const WrappedNormalLoginForm = Form.create()(Equivalencias);
if (document.getElementById("root")) {
  const el = document.getElementById("root");
  const props = Object.assign({}, el.dataset);
  ReactDOM.render(<WrappedNormalLoginForm {...props} />, el);
}

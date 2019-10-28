import "antd/dist/antd.css";
import { Modal, Button, Form, Select, Table, Divider, Tag, Spin } from "antd";
const FormItem = Form.Item;
const { Option } = Select;

class Equivalencias extends React.Component {
  constructor(props) {
    super(props);
    this.showModal = this.showModal.bind(this);
    this.handleOk = this.handleOk.bind(this);
    this.handleCancel = this.handleCancel.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.getSubjectsDestination = this.getSubjectsDestination.bind(this);
    this.createEquivalentSubject = this.createEquivalentSubject.bind(this);
    this.getEquivalentSubject = this.getEquivalentSubject.bind(this);
    this.deleteEquivalentSubject = this.deleteEquivalentSubject.bind(this);
    this.state = {
      visible: false,
      loading: true,
      subjectOrigin: [],
      subjectDestination: [],
      dataTable: [],
      columns: [
        {
          title: "Asignatura Equivalente",
          dataIndex: "subjectName",
          key: "subjectName",
          render: text => <span>{text}</span>
        },
        {
          title: "Codigo",
          dataIndex: "subjectCode",
          key: "subjectCode",
          render: text => <span>{text}</span>
        },
        {
          title: "Unidades de credito",
          dataIndex: "subjectsCredits",
          key: "subjectsCredits"
        },
        {
          title: "Acciones",
          key: "action",
          render: (text, record) => (
            <span>
              <a
                href="javascript:;"
                onClick={e => {
                  e.stopPropagation();
                  console.log(record);
                  let confirm = window.confirm(
                    "Esta seguro que desea eliminar la fila seleccionada?"
                  );
                  if (confirm) {
                    console.log("si");
                    this.deleteEquivalentSubject(record);
                    this.setState({
                      loading: true
                    });
                  }
                }}
              >
                Eliminar
              </a>
            </span>
          )
        }
      ]
    };
  }

  componentDidMount() {
    this.getEquivalentSubject();
    this.getSubjectsDestination();
  }

  deleteEquivalentSubject(record) {
    let { voucher_id } = this.props;
    let _this = this;
    fetch("/admin/voucher/deleteEquivalentSubject", {
      method: "post",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      body: JSON.stringify({
        record
      })
    })
      .then(function(response) {
        _this.getEquivalentSubject();
        _this.getSubjectsDestination();
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
        console.log(data);
        _this.setState({ subjectDestination: data });
      })
      .catch(function(e) {
        console.log(e);
      });
  }

  getEquivalentSubject() {
    let { voucher_id } = this.props;
    let _this = this;
    let acum = "";
    // _this.setState({ dataTable: [], loading: false });
    fetch("/admin/voucher/getEquivalentSubject/" + voucher_id, {
      method: "get",
      credentials: "same-origin"
    })
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        _this.setState({ dataTable: data, loading: false });
      })
      .catch(function(e) {
        console.log(e);
      });
  }

  createEquivalentSubject(values) {
    let { voucher_id } = this.props;
    let _this = this;
    fetch("/admin/voucher/createEquivalentSubject", {
      method: "post",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      body: JSON.stringify({
        values,
        voucher_id
      })
    })
      .then(function(response) {
        _this.getEquivalentSubject();
        _this.getSubjectsDestination();
      })
      .catch(function(e) {
        console.log(e);
      });
  }

  showModal() {
    this.setState({
      visible: true
    });
    this.props.form.resetFields();
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
    let { voucher_id } = this.props;
    const { form } = this.props;
    if (e) {
      e.preventDefault();
    }
    form.validateFieldsAndScroll((err, values) => {
      if (!err) {
        console.log(values);
        this.createEquivalentSubject(values);
        this.setState({
          visible: false,
          loading: true
        });
      }
    });
  }

  render() {
    const { form } = this.props;
    const { getFieldDecorator } = form;
    const { subjectDestination } = this.state;

    const { columns } = this.state;
    const { dataTable, loading } = this.state;

    const optionsSubjectDestination = subjectDestination.map(d => (
      <Option key={d.id} value={d.id}>
        {d.name}
      </Option>
    ));
    return (
      <div>
        <div id="divTable">
          <Table
            style={{ backgroundColor: "white", marginLeft: 10 }}
            locale={{
              emptyText: "No se han agregado asignaturas para este comprobante"
            }}
            loading={loading}
            columns={columns}
            dataSource={dataTable}
          />
        </div>
        <Button
          type="primary"
          onClick={this.showModal}
          style={{ marginTop: 10, float: "right" }}
          loading={loading}
        >
          Agregar asignatura equivalente
        </Button>
        <Modal
          title="Por favor, seleccione las asignaturas equivalentes"
          visible={this.state.visible}
          onOk={this.handleSubmit}
          okText={"Agregar"}
          cancelText={"Cancelar"}
          onCancel={this.handleCancel}
        >
          <Form onSubmit={this.handleSubmit}>
            <FormItem label="Asignatura equivalente">
              {getFieldDecorator("approvedSubject", {
                rules: [
                  {
                    required: true,
                    message: "Este campo es requerido"
                  }
                ]
              })(
                <Select
                  notFoundContent="No se encontraron materias para la carrera de destino"
                  showSearch
                  filterOption={(input, option) =>
                    option.props.children
                      .toLowerCase()
                      .indexOf(input.toLowerCase()) >= 0
                  }
                  style={{ width: "100%" }}
                  mode="multiple"
                  placeholder="Seleccione"
                  allowClear
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

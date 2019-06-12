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
    this.getSubjectsOrigin = this.getSubjectsOrigin.bind(this);
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
          dataIndex: "approvedSubject",
          key: "approvedSubject",
          render: text => <span>{text}</span>
        },
        {
          title: "Codigos de materias",
          dataIndex: "equivalentsSubjects",
          key: "equivalentsSubjects",
          render: text => <span>{text}</span>
        },
        {
          title: "Unidades de credito",
          dataIndex: "credits",
          key: "credits"
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
    this.getSubjectsOrigin();
    this.getSubjectsDestination();
  }

  deleteEquivalentSubject(record) {
    let { voucher_id } = this.props;
    let _this = this;
    console.log("++++++");
    console.log(record);
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
    fetch("/admin/voucher/getEquivalentSubject/" + voucher_id, {
      method: "get",
      credentials: "same-origin"
    })
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        data = data.map(aux => {
          aux.key = aux.id;
          aux.approvedSubject =
            aux.subjectName + " (Cod - " + aux.subjectId + ")";
          aux.equivalentId = aux.subjectEquivalentId.split(",");
          aux.equivalentName = aux.subjectEquivalentName.split(",");
          for (let i = 0; i < aux.equivalentId.length; i++) {
            acum +=
              aux.equivalentName[i] + " (Cod - " + aux.equivalentId[i] + ") ";
          }
          aux.equivalentsSubjects = acum;
          acum = "";
          aux.credits = aux.subjectsCredits;
          return aux;
        });
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
        // this.getEquivalentSubject();
        // this.getSubjectsOrigin();
        // this.getSubjectsDestination();
        this.setState({
          visible: false,
          loading: true
        });
        //   () => {
        //     this.getEquivalentSubject();
        //     this.getSubjectsOrigin();
        //     this.getSubjectsDestination();
        //   }
        // );
      }
    });
  }

  render() {
    const { form } = this.props;
    const { getFieldDecorator } = form;
    const { subjectOrigin } = this.state;
    const { subjectDestination } = this.state;

    const { columns } = this.state;
    const { dataTable, loading } = this.state;
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
                initialValue: "",
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
                  placeholder="Seleccione"
                  allowClear
                >
                  {optionsSubjectDestination}
                </Select>
              )}
            </FormItem>
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
                  notFoundContent="No se encontraron materias para la carrera de origen"
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
                  {optionsSubjectOrigin}
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

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
    this.createEquivalentSubject = this.createEquivalentSubject.bind(this);
    this.getEquivalentSubject = this.getEquivalentSubject.bind(this);
    this.state = {
      visible: false,
      subjectOrigin: [],
      subjectDestination: [],
      // dataTable: [
      //   {
      //     key: "1",
      //     approvedSubject: "John Brown",
      //     equivalentsSubjects: ["nice", "developer"],
      //     credits: 32
      //   },
      //   {
      //     key: "2",
      //     approvedSubject: "Jim Green",
      //     equivalentsSubjects: ["loser"],
      //     credits: 42
      //   },
      //   {
      //     key: "3",
      //     approvedSubject: "Joe Black",
      //     equivalentsSubjects: ["cool", "teacher"],
      //     credits: 32
      //   }
      // ],
      columns: [
        {
          title: "Asignatura Equivalente",
          dataIndex: "approvedSubject",
          key: "approvedSubject",
          render: text => <span>{text}</span>
        },
        {
          title: "Codigos de materias",
          key: "equivalentsSubjects",
          dataIndex: "equivalentsSubjects",
          render: tags => (
            <span>
              {tags.map(tag => {
                let color = tag.length > 5 ? "geekblue" : "green";
                if (tag === "loser") {
                  color = "volcano";
                }
                return (
                  <Tag color={color} key={tag}>
                    {tag.toUpperCase()}
                  </Tag>
                );
              })}
            </span>
          )
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
              <a href="javascript:;">Delete</a>
            </span>
          )
        }
      ]
    };
  }

  componentDidMount() {
    //llamar a la funcion que trae los datos de la tabla
    this.getEquivalentSubject();
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

  createEquivalentSubject(values) {
    let { voucher_id } = this.props;
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
        console.log(response);
      })
      .catch(function(e) {
        console.log("entre en el catch");
        console.log(e);
      });
  }

  getEquivalentSubject() {
    let { voucher_id } = this.props;
    let _this = this;
    fetch("/admin/voucher/getEquivalentSubject/" + voucher_id, {
      method: "get",
      credentials: "same-origin"
    })
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        let fullArray = JSON.stringify(data);
        console.log(data);
        // _this.setState({ dataTable: fullArray });
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
          visible: false
        });
      }
    });
  }

  render() {
    const { form } = this.props;
    const { getFieldDecorator } = form;
    const { subjectOrigin } = this.state;
    const { subjectDestination } = this.state;

    const { columns } = this.state;
    const { dataTable } = this.state;
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
        <Table
          style={{ backgroundColor: "white", marginLeft: 50 }}
          locale={{
            emptyText: "No se han agregado asignaturas para este comprobante"
          }}
          columns={columns}
          dataSource={dataTable}
        />
        <Button
          type="primary"
          onClick={this.showModal}
          style={{ marginTop: 10, float: "right" }}
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

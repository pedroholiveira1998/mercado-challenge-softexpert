import Table from '@mui/material/Table'
import TableBody from '@mui/material/TableBody'
import TableCell from '@mui/material/TableCell'
import TableContainer from '@mui/material/TableContainer'
import TableHead from '@mui/material/TableHead'
import TableRow from '@mui/material/TableRow'
import Paper from '@mui/material/Paper'
import Typography from '@mui/material/Typography'
import Button from '@mui/material/Button'
import AddIcon from '@mui/icons-material/Add'
import EditIcon from '@mui/icons-material/Edit'
import { DeleteForever } from '@mui/icons-material'

const ProductTypesTable = ({ productTypes, onCreate, onEdit, onDelete }) => {
  return (
    <TableContainer
      sx={{ marginTop: 4, boxShadow: 'rgba(0, 0, 0, 0.1) 0px 4px 12px;' }}
    >
      <Typography
        variant="h6"
        textAlign="center"
        sx={{ marginBottom: 2, marginTop: 4 }}
      >
        Tipos de Produto
      </Typography>
      <Table>
        <TableHead>
          <TableRow>
            <TableCell>Nome</TableCell>
            <TableCell>Taxa de Imposto</TableCell>
            <TableCell align="right">
              <Button
                variant="contained"
                color="success"
                startIcon={<AddIcon />}
                size="small"
                onClick={() => onCreate()}
              >
                Novo Tipo de Produto
              </Button>
            </TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {productTypes.map((productType) => (
            <TableRow key={productType.id}>
              <TableCell>{productType.name}</TableCell>
              <TableCell>{productType.tax_rate}%</TableCell>
              <TableCell align="right">
                <Button
                  sx={{ marginRight: '8px' }}
                  variant="outlined"
                  color="warning"
                  startIcon={<EditIcon />}
                  size="small"
                  onClick={() => onEdit(productType)}
                >
                  Editar
                </Button>
                <Button
                  variant="outlined"
                  color="error"
                  startIcon={<DeleteForever />}
                  size="small"
                  onClick={() => onDelete(productType)}
                >
                  Excluir
                </Button>
              </TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  )
}

export default ProductTypesTable

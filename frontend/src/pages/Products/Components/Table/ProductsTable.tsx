import React from 'react'
import Table from '@mui/material/Table'
import TableBody from '@mui/material/TableBody'
import TableCell from '@mui/material/TableCell'
import TableContainer from '@mui/material/TableContainer'
import TableHead from '@mui/material/TableHead'
import TableRow from '@mui/material/TableRow'
import Typography from '@mui/material/Typography'
import Button from '@mui/material/Button'
import AddIcon from '@mui/icons-material/Add'
import EditIcon from '@mui/icons-material/Edit'
import { DeleteForever } from '@mui/icons-material'

const ProductsTable = ({ products, onCreate, onEdit, onDelete }) => {
  return (
    <TableContainer
      sx={{ marginTop: 4, boxShadow: 'rgba(0, 0, 0, 0.1) 0px 4px 12px;' }}
    >
      <Typography
        variant="h6"
        textAlign="center"
        sx={{ marginBottom: 2, marginTop: 4 }}
      >
        Produtos
      </Typography>
      <Table>
        <TableHead>
          <TableRow>
            <TableCell>Nome</TableCell>
            <TableCell>Preço</TableCell>
            <TableCell>Tipo de Produto</TableCell>
            <TableCell>Quantidade em Estoque</TableCell>
            <TableCell>Taxa de Imposto</TableCell>
            <TableCell align="right">
              <Button
                variant="contained"
                color="success"
                startIcon={<AddIcon />}
                size="small"
                onClick={onCreate}
              >
                Novo Produto
              </Button>
            </TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {products.map((product, index) => (
            <TableRow key={index}>
              <TableCell>{product.name}</TableCell>
              <TableCell>R$ {product.price}</TableCell>
              <TableCell>{product.type_name}</TableCell>
              <TableCell>{product.quantity_in_stock}</TableCell>
              <TableCell>{product.tax_rate}%</TableCell>
              <TableCell align="right">
                <Button
                  variant="outlined"
                  color="warning"
                  startIcon={<EditIcon />}
                  size="small"
                  sx={{ marginRight: '8px' }}
                  onClick={() => onEdit(product)}
                >
                  Editar
                </Button>
                <Button
                  variant="outlined"
                  color="error"
                  startIcon={<DeleteForever />}
                  size="small"
                  onClick={() => onDelete(product)}
                >
                  Deletar
                </Button>
              </TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  )
}

export default ProductsTable

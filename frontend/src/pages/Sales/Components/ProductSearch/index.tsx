import React from 'react'
import {
  Typography,
  Paper,
  TableContainer,
  Table,
  TableHead,
  TableRow,
  TableCell,
  TableBody,
  TextField,
  IconButton,
  Grid,
  FormControl,
  InputAdornment,
} from '@mui/material'
import {
  Search as SearchIcon,
  Add as AddIcon,
  ShoppingCart as ShoppingCartIcon,
} from '@mui/icons-material'
import RenderProducts from '../RenderProducts'

const ProductList = ({ products, cartItems, onAddToCart, onRemoveToCart }) => {
  const [filteredProducts, setFilteredProducts] = React.useState(products)
  const [searchQuery, setSearchQuery] = React.useState('')

  const handleSearch = () => {
    const filtered = products.filter((product) =>
      product.name.toLowerCase().includes(searchQuery.toLowerCase()),
    )
    setFilteredProducts(filtered)
  }

  React.useEffect(() => {
    setFilteredProducts(products)
  }, [products])

  return (
    <Paper sx={{ padding: 2 }}>
      <Typography variant="h5" gutterBottom>
        Lista de Produtos
      </Typography>
      <Grid container spacing={2} alignItems="center">
        <Grid item xs={12} md={6}>
          <TextField
            fullWidth
            label="Pesquisar"
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)}
            variant="outlined"
            InputProps={{
              endAdornment: (
                <InputAdornment position="end">
                  <IconButton onClick={handleSearch}>
                    <SearchIcon />
                  </IconButton>
                </InputAdornment>
              ),
            }}
          />
        </Grid>
        <Grid item xs={12} md={6} textAlign="right">
          {' '}
          {/* Adicionei textAlign para alinhar à direita */}
          <IconButton onClick={() => console.log('Carrinho clicado')}>
            <ShoppingCartIcon /> {/* Ícone do carrinho */}
          </IconButton>
        </Grid>
      </Grid>
      <TableContainer>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>Nome</TableCell>
              <TableCell>Preço</TableCell>
              <TableCell>Quantidade em Estoque</TableCell>
              <TableCell>Adicionar ao Carrinho</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {filteredProducts.map((product) => (
              <RenderProducts
                filteredProducts={filteredProducts}
                product={product}
                cartItems={cartItems}
                onAddToCart={onAddToCart}
                onRemoveToCart={onRemoveToCart}
              />
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </Paper>
  )
}

export default ProductList

import { createRoot } from 'react-dom/client'
export function mountWidget(container, Component) {
  const props = container.dataset.props
    ? JSON.parse(container.dataset.props)
    : {}
  createRoot(container).render(<Component {...props} />)
}
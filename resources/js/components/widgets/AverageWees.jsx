import StatCard from '../StatCard'
export default function AverageWees({ value, windowDays }) {
  return (
    <StatCard
      label="Avg wees per day"
      value={value}
      hint={`Last ${windowDays} days`}
    />
  )
}
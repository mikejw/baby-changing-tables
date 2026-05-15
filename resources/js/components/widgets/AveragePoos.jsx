import StatCard from '../StatCard'
export default function AveragePoos({ value, windowDays }) {
  return (
    <StatCard
      label="Avg poos per day"
      value={value}
      hint={`Last ${windowDays} days`}
    />
  )
}
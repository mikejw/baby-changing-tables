import { mountWidget } from './mounts/mountWidget';
import LastFeedSummary from './components/widgets/LastFeedSummary';
import TimeSinceLastFeed from './components/widgets/TimeSinceLastFeed';
import AveragePoos from './components/widgets/AveragePoos';
import AverageWees from './components/widgets/AverageWees';
import AverageDailyFormula from './components/widgets/AverageDailyFormula';
const registry = {
  'last-feed-summary': LastFeedSummary,
  'time-since-last-feed': TimeSinceLastFeed,
  'avg-poos': AveragePoos,
  'avg-wees': AverageWees,
  'avg-daily-formula': AverageDailyFormula,
}
document.querySelectorAll('[data-widget]').forEach((el) => {
  const name = el.dataset.widget
  const Component = registry[name]
  if (Component) mountWidget(el, Component)
})